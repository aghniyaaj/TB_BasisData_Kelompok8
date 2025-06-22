<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM menu_minuman WHERE id=$id");
header("Location: minuman.php");
exit;
?>
