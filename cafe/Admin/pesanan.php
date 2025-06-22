<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy&display=swap" rel="stylesheet">
    <title>Daftar Pesanan</title>
    <style>
        body {
            font-family: 'Sour Gummy', cursive;
            margin: 0;
            padding: 30px;
            background: url('../bg1.jpeg') no-repeat center center fixed;
            background-size: cover;
            background-color: #fdfdfd;
        }
        
        h2 {
            text-align: center;
            color: #e91e63;
            font-size: 32;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th {
            background-color: #fce4ec;
            color: #880e4f;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn {
            padding: 6px 14px;
            background-color: #f06292;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #d81b60;
        }
    </style>
</head>
<body>

<h2>Daftar Pesanan</h2>
<a href="dashboard.php" class="btn">← Kembali ke Dashboard</a>
<table>
    <thead>
        <tr>
            <th>ID Pesanan</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Tanggal</th>
            <th>Metode</th>
            <th>Status</th>
            <th>Rincian</th>
            <th>Total</th>
            <th>Bukti Transfer</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "
        SELECT p.id AS id_pesanan, p.tanggal, p.status, p.metode_pengiriman, p.bukti_transfer,
               pl.nama, pl.no_hp, pl.alamat,
               dp.kategori, dp.jumlah, dp.subtotal,
               COALESCE(mm.nama_menu, mn.nama_menu) AS nama_menu
        FROM pesanan p
        JOIN pelanggan pl ON p.id_pelanggan = pl.id
        LEFT JOIN detail_pesanan dp ON dp.id_pesanan = p.id
        LEFT JOIN menu_makanan mm ON dp.kategori = 'makanan' AND dp.id_menu = mm.id
        LEFT JOIN menu_minuman mn ON dp.kategori = 'minuman' AND dp.id_menu = mn.id
        ORDER BY p.id DESC
    ";

    $result = mysqli_query($koneksi, $query);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id_pesanan'];
        if (!isset($data[$id])) {
            $data[$id] = [
                'info' => [
                    'nama' => $row['nama'],
                    'no_hp' => $row['no_hp'],
                    'alamat' => $row['alamat'],
                    'tanggal' => $row['tanggal'],
                    'metode' => $row['metode_pengiriman'],
                    'status' => $row['status'],
                    'bukti_transfer' => $row['bukti_transfer'] ?? ''
                ],
                'rincian' => [],
                'total' => 0
            ];
        }

        if (!empty($row['nama_menu'])) {
            $data[$id]['rincian'][] = [
                'kategori' => $row['kategori'],
                'nama_menu' => $row['nama_menu'],
                'jumlah' => $row['jumlah'],
                'subtotal' => $row['subtotal']
            ];
            $data[$id]['total'] += $row['subtotal'];
        }
    }

    foreach ($data as $id => $pesanan) {
        $info = $pesanan['info'];
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>{$info['nama']}</td>";
        echo "<td>{$info['no_hp']}</td>";
        echo "<td>{$info['alamat']}</td>";
        echo "<td>{$info['tanggal']}</td>";
        echo "<td>{$info['metode']}</td>";
        echo "<td>{$info['status']}</td>";


        echo "<td>";
        if (!empty($pesanan['rincian'])) {
            echo "<ul style='padding-left: 15px; margin: 0'>";
            foreach ($pesanan['rincian'] as $item) {
                echo "<li><strong>" . ucfirst($item['kategori']) . ":</strong> {$item['nama_menu']} x {$item['jumlah']} = Rp " . number_format($item['subtotal'], 0, ',', '.') . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Tidak ada item";
        }
        echo "</td>";

        echo "<td>Rp " . number_format($pesanan['total'], 0, ',', '.') . "</td>";
        
        // Kolom bukti transfer
        echo "<td>";
        if (!empty($info['bukti_transfer'])) {
            echo "<a href='../bukti_transfer/{$info['bukti_transfer']}' target='_blank'>
                    <img src='../bukti_transfer/{$info['bukti_transfer']}' alt='Bukti' style='max-height: 80px; border-radius: 6px; box-shadow: 0 0 6px rgba(0,0,0,0.2);'>
                </a>";
        } else {
            echo "<em>Belum diunggah</em>";
        }
        echo "</td>";


        echo "<td>
                <a href='struk.php?id=$id' class='btn' target='_blank'>Struk</a><br><br>
                <a href='edit_pesanan.php?id=$id' class='btn'>Edit</a>
                <a href='hapus_pesanan.php?id=$id' class='btn' onclick=\"return confirm('Yakin ingin menghapus pesanan ini?')\">Hapus</a>
              </td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

</body>
</html>
