<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sour Gummy', cursive;
            background: url('../bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 50px 20px;
            margin: 0;
        }
        
        .welcome-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
            text-align: center;
        }
        
        h1 {
            color: #f06292;
            margin: 0 0 30px 0;
            font-size: 3rem;
            text-shadow: 2px 2px 4px rgba(241, 183, 220, 0.3);
        }
        
        .button-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            max-width: 800px;
            width: 100%;
        }
        
        .btn {
            background-color: #f06292;
            color: white;
            padding: 20px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1.2rem;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn:hover {
            background-color: #d81b60;
            transform: translateY(-3px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        
        @media (max-width: 600px) {
            .button-container {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Selamat Datang, Admin!</h1>
    </div>
    
    <div class="button-container">
        <a href="makanan.php" class="btn">Kelola Menu Makanan</a>
        <a href="minuman.php" class="btn">Kelola Menu Minuman</a>
        <a href="pesanan.php" class="btn">Lihat Pesanan</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
