<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM menu_minuman WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    mysqli_query($koneksi, "UPDATE menu_minuman SET nama_menu='$nama', harga=$harga, deskripsi='$deskripsi' WHERE id=$id");
    header("Location: minuman.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Minuman</title>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sour Gummy', cursive;
            background: url('../bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            padding: 100px;
            color: white;
        }
        form {
            background-color: rgba(255,255,255,0.9);
            padding: 30px;
            border-radius: 10px;
            color: black;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
        }
        button {
            padding: 10px 20px;
            background-color: #f06292;
            border: none;
            color: white;
            border-radius: 5px;
        }
        button:hover {
            background-color: #d81b60;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Edit Menu Minuman</h2>
        <label>Nama Minuman</label>
        <input type="text" name="nama_menu" value="<?= $data['nama_menu'] ?>" required>
        <label>Harga</label>
        <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
        <label>Deskripsi</label>
        <input type="text" name="deskripsi" value="<?= $data['deskripsi'] ?>" required>
        <button type="submit">Update</button>
        <button type="minuman.php" class="button">Kembali</button>
    </form>
</body>
</html>
