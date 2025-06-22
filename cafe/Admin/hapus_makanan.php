<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM menu_makanan WHERE id=$id");
header("Location: makanan.php");
exit;
?>
