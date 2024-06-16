<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn = $_POST['nisn'];
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $sql = "
        SELECT siswa.nama, absensi.tanggal, absensi.status, absensi.deskripsi 
        FROM absensi 
        INNER JOIN siswa ON absensi.id_siswa = siswa.id 
        WHERE siswa.nisn = '$nisn' 
        AND absensi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ";
    
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orang Tua - Lihat Rekap Absensi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Rekap Absensi Anak</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="nisn">Nomor Induk Siswa Nasional (NISN):</label>
                <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Masukkan NISN siswa" required>
            </div>
            <div class="form-group">
                <label for="tanggal_awal">Tanggal Awal:</label>
                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required>
            </div>
            <div class="form-group">
                <label for="tanggal_akhir">Tanggal Akhir:</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required>
            </div>
            <button type="submit" class="btn btn-primary">Lihat Rekap Absensi</button>
            <a href="logout.php" class="btn btn-primary">Halaman login</a>
        </form>
        <?php if(isset($result) && $result->num_rows > 0) { ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['tanggal']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['deskripsi']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else if(isset($result)) { ?>
            <div class="alert alert-warning" role="alert">
                Data absensi tidak ditemukan untuk NISN yang dimasukkan dalam rentang tanggal tertentu.
            </div>
        <?php } ?>
    </div>
</body>
</html>
