<?php
include 'koneksi.php';

error_log(print_r($_FILES, true));
// Validasi input POST
if (!isset($_POST['nama']) || !isset($_POST['no_hp']) || !isset($_POST['alamat']) || 
    !isset($_POST['menu']) || !isset($_POST['jumlah']) || !isset($_POST['metode'])) {
    header("Location: admin/login.php?pesan=data_tidak_lengkap");
    exit;
}

$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$menu = $_POST['menu'];
$jumlah = $_POST['jumlah'];
$pengiriman = mysqli_real_escape_string($koneksi, $_POST['metode']);

try {
    // Mulai transaksi
    mysqli_autocommit($koneksi, false);

    // Insert data pelanggan
    $query_pelanggan = "INSERT INTO pelanggan (nama, no_hp, alamat) VALUES ('$nama', '$no_hp', '$alamat')";
    if (!mysqli_query($koneksi, $query_pelanggan)) {
        throw new Exception("Error inserting pelanggan: " . mysqli_error($koneksi));
    }
    $id_pelanggan = mysqli_insert_id($koneksi);

    // Insert pesanan
    $query_pesanan = "INSERT INTO pesanan (id_pelanggan, metode_pengiriman) VALUES ($id_pelanggan, '$pengiriman')";
    if (!mysqli_query($koneksi, $query_pesanan)) {
        throw new Exception("Error inserting pesanan: " . mysqli_error($koneksi));
    }
    $id_pesanan = mysqli_insert_id($koneksi);

    // Insert detail pesanan
    foreach ($menu as $index => $data) {
        if (empty($data)) continue;
        $menu_parts = explode('|', $data);
        if (count($menu_parts) < 3) continue;

        list($kategori, $nama_menu, $harga) = $menu_parts;

        $kategori = mysqli_real_escape_string($koneksi, $kategori);
        $nama_menu = mysqli_real_escape_string($koneksi, $nama_menu);
        $harga = floatval($harga);

        $jml = 1;
        $possible_keys = [
            $index,
            $kategori . "_" . $index,
            $nama_menu,
            $kategori . "_" . $nama_menu
        ];
        foreach ($possible_keys as $key) {
            if (isset($jumlah[$key]) && intval($jumlah[$key]) > 0) {
                $jml = intval($jumlah[$key]);
                break;
            }
        }

        $subtotal = $harga * $jml;
        $tabel_menu = ($kategori === 'makanan') ? 'menu_makanan' : 'menu_minuman';
        $query_get_menu = "SELECT id FROM $tabel_menu WHERE nama_menu = '$nama_menu' LIMIT 1";
        $result_menu = mysqli_query($koneksi, $query_get_menu);

        if (!$result_menu) {
            throw new Exception("Error querying menu: " . mysqli_error($koneksi));
        }

        $row_menu = mysqli_fetch_assoc($result_menu);
        $id_menu = $row_menu ? $row_menu['id'] : 0;

        if ($id_menu == 0) continue;

        $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_menu, kategori, jumlah, subtotal) 
                         VALUES ($id_pesanan, $id_menu, '$kategori', $jml, $subtotal)";
        if (!mysqli_query($koneksi, $query_detail)) {
            throw new Exception("Error inserting detail pesanan: " . mysqli_error($koneksi));
        }
    }

    // Upload bukti transfer jika ada
    if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] === 0) {
    $uploadDir = "bukti_transfer/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $ext = pathinfo($_FILES['bukti_transfer']['name'], PATHINFO_EXTENSION);
    $namaFile = uniqid("bukti_") . '.' . $ext;
    $targetPath = $uploadDir . $namaFile;

    if (move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $targetPath)) {
        $query_update_bukti = "UPDATE pesanan SET bukti_transfer = '$namaFile' WHERE id = $id_pesanan";
        if (!mysqli_query($koneksi, $query_update_bukti)) {
            throw new Exception("Gagal menyimpan nama file bukti transfer ke DB.");
        }
    } else {
        throw new Exception("Gagal memindahkan file ke folder tujuan.");
        }
    }

    mysqli_commit($koneksi);
    mysqli_autocommit($koneksi, true);

    // Redirect setelah sukses
    header("Location: pesanan_berhasil.php");
    exit;

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    mysqli_autocommit($koneksi, true);
    error_log("Order processing error: " . $e->getMessage());
    header("Location: gagal.php?error=" . urlencode($e->getMessage()));
    exit;
}
?>
