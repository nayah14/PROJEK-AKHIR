<?php
include('session.php');

$login_error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!login($username, $password, $role)) {
        $login_error = true;
    } else {
        if (isAdmin()) {
            header("location: admin.php");
            exit();
        } else if (isKetuaKelas()){
            header("location: ketua_kelas.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            background-image: url(1.jpeg);
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        form {
            max-width: 100%;
            width: 310px;
            background-color: #fff7f785;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        input, select {
            width: 100%;
            height: 40px;
            margin-top: 10px;
            border-radius: 2px;
            border: 1px solid rgb(202, 198, 198);
            padding-left: 10px;
            box-sizing: border-box;
        }

        .login, .extra-button {
            border-radius: 5px;
            border: none;
            width: 100%;
            margin-top: 20px;
            cursor: pointer;
            height: 40px;
        }

        .login {
            background-color: black;
            color: white;
        }

        .extra-button {
            background-color: grey;
            color: white;
            margin-top: 10px;
        }

        .extra-button:hover {
            background-color: darkgrey;
        }

        @media (max-width: 600px) {
            form {
                width: 90%;
                margin: 0 5%;
            }

            input, select, .login, .extra-button {
                height: 35px;
            }
        }
    </style>
    <script>
        function showError(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <?php if ($login_error): ?>
        <script>
            showError('password/username tidak sesuai');
        </script>
    <?php endif; ?>

    <form method="post" action="">
        <h1>Login</h1>
        <input type="text" id="username" name="username" required placeholder="Username"><br><br>
        <input type="password" id="password" name="password" required placeholder="Password"><br><br>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="ketua_kelas">Ketua Kelas</option>
        </select><br>
        <input type="submit" value="Login" class="login">
        <button type="button" class="extra-button" onclick="location.href='orang_tua.php'">Akses Web Orang Tua</button>
    </form>
</body>
</html>
