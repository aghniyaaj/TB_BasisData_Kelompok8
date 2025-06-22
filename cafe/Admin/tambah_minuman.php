<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $harga = floatval($_POST['harga']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    if (!empty($nama) && $harga > 0) {
        $query = "INSERT INTO menu_minuman (nama_menu, harga, deskripsi) VALUES ('$nama', $harga, '$deskripsi')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            header("Location: minuman.php?status=berhasil");
            exit;
        } else {
            echo "Gagal menambahkan: " . mysqli_error($koneksi);
        }
    } else {
        echo "Nama menu dan harga wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu Makanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sour Gummy', cursive;
            background: url('../bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            padding: 60px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            background: rgba(255,255,255,0.95);
            padding: 25px;
            border-radius: 15px;
            color: #333;
        }
        label {
            display: block;
            margin: 15px 0 5px;
        }
        input, textarea {
            width: 100%;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            background-color: #f06292;
            color: white;
            border: none;
            padding: 10px 25px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #d81b60;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Menu Minuman</h2>
        <form method="POST">
            <label>Nama Menu</label>
            <input type="text" name="nama" required>

            <label>Harga</label>
            <input type="number" name="harga" min="1" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4"></textarea>

            <button type="submit">Simpan</button>
            <button type="minuman.php">Kembali</button>
        </form>
    </div>
</body>
</html>
