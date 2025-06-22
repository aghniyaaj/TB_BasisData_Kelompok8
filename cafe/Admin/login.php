<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Sour Gummy', cursive;
        }

        body {
            margin: 0;
            padding: 0;
            background: url('../bg1.jpeg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-login {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .form-login h2 {
            margin-bottom: 5px;
            font-size: 24px;
            color: #333;
        }

        .form-login p {
            color: #888;
            margin-bottom: 25px;
        }

        .input-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .btn-login {
            width: 100%;
            background-color: #e91e63;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-login:hover {
            background-color: #d81b60;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <form action="cek_login.php" method="POST" class="form-login">
        <h2>Admin Portal</h2>
        <p>Silakan masuk ke akun Anda</p>

        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>

        <button type="submit" class="btn-login">Masuk</button>

        <div class="footer">
            © 2025 Sistem Admin. All rights reserved.
        </div>
    </form>
</body>
</html>
