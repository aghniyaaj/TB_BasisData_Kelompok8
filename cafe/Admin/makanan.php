<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';
$result = mysqli_query($koneksi, "SELECT * FROM menu_makanan");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu Makanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sour Gummy', cursive;
            background: url('../bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            padding: 30px;
        }
        .header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #f06292;
            margin: 0;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(241, 183, 220, 0.3);
        }
        .button-group {
            display: flex;
            gap: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.9);
            color: black;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f06292;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        .btn {
            padding: 6px 12px;
            margin: 2px;
            background-color: #f06292;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #d81b60;
        }
        .btn i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div clas="header">
        <h2>Daftar Menu Makanan</h2>
        <div class="button-group"> 
            <a href="dashboard.php" class="btn">← Kembali ke Dashboard</a>
            <a href="tambah_makanan.php" class="btn">+ Tambah Makanan</a>
        </div>  
    </div>
    <table>
        <tr>
            <th>Nama Menu</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $row['nama_menu']; ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
            <td><?= $row['deskripsi']; ?></td>
            <td>
                <a class="btn" href="edit_makanan.php?id=<?= $row['id']; ?>">Edit</a>
                <a class="btn" href="hapus_makanan.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
