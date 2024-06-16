<?php
include('session.php');

if (!isAdmin()) {
    header("location: login.php");
    exit;
}

include('db.php');

$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Mengambil data absensi siswa berdasarkan tanggal tertentu
$sql = "
    SELECT absensi.*, siswa.nama AS nama_siswa, tb_kelas.nama AS nama_kelas 
    FROM absensi 
    INNER JOIN siswa ON absensi.id_siswa = siswa.id 
    INNER JOIN tb_kelas ON siswa.id_kelas = tb_kelas.id 
    WHERE absensi.tanggal = '$tanggal'
";
$absensi_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Rekap Absensi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Rekap Absensi untuk Tanggal <?php echo $tanggal; ?></h1>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $absensi_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['nama_siswa']; ?></td>
                    <td><?php echo $row['nama_kelas']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['deskripsi']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>