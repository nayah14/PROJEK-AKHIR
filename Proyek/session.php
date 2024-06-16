<?php
session_start();

$login_error_message = "";

function login($username, $password, $role) {
    include('db.php');
    global $login_error_message;

    if ($role == 'admin') {
        $result = $conn->query("SELECT * FROM admin WHERE username='$username'");
    } elseif ($role == 'ketua_kelas') {
        $result = $conn->query("SELECT * FROM ketua_kelas WHERE username='$username'");
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = $row['id'];
            return true;
        } else {
            $login_error_message = "Password tidak cocok.";
        }
    } else {
        $login_error_message = "Pengguna tidak ditemukan.";
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return $_SESSION['role'] == 'admin';
}

function isKetuaKelas() {
    return $_SESSION['role'] == 'ketua_kelas';
}

function logout() {
    session_destroy();
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $username = $_POST['username'];
//     $password = $_POST['password'];
//     $role = $_POST['role'];

//     if (!login($username, $password, $role)) {
//         // $login_error_message will be set inside the login function
//     } else {
//         if (isAdmin()) {
//             header("location: admin.php");
//             exit();
//         } else if (isKetuaKelas()) {
//             header("location: ketua_kelas.php");
//             exit();
//         }
//     }
// }
?>