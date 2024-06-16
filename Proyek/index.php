<?php
include('session.php');

if (!isLoggedIn()) {
    header("location: login.php");
    exit;
}

if (isAdmin()) {
    header("location: admin.php");
} elseif (isKetuaKelas()) {
    header("location: ketua_kelas.php");
} else {
    echo "Peran tidak valid";
}
?>