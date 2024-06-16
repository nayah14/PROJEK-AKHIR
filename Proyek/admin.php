<?php
include('session.php');

if (!isAdmin()) {
    header("location: login.php");
    exit;
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        $sql_delete = "DELETE FROM rentang_pekanan WHERE id = '$delete_id'";
        if ($conn->query($sql_delete) === TRUE) {
            echo "Rentang pekanan berhasil dihapus";
            // Redirect to prevent form resubmission
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        } else {
            echo "Error: " . $sql_delete . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['submit_rentang_pekanan'])) {
        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];
        $pekan_ke = $_POST['pekan_ke'];
        $bulan = $_POST['bulan'];

        $sql = "INSERT INTO rentang_pekanan (tgl_awal, tgl_akhir, pekan_ke, bulan) 
            VALUES ('$tgl_awal', '$tgl_akhir', '$pekan_ke', '$bulan')
            ON DUPLICATE KEY UPDATE tgl_awal=VALUES(tgl_awal), tgl_akhir=VALUES(tgl_akhir)";

        if ($conn->query($sql) === TRUE) {
            echo "Rentang pekanan berhasil ditambahkan";
            // Redirect to prevent form resubmission
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['submit_siswa'])) {
        $id = $_POST['id']; // Ambil nilai ID siswa dari formulir
        $nama = $_POST['nama'];
        $nis = $_POST['nis'];
        $nisn = $_POST['nisn'];
        $alamat = $_POST['alamat'];
        $tgl_lahir = $_POST['tgl_lahir'];
        $id_kelas = $_POST['id_kelas'];
    
        $sql = "INSERT INTO siswa (id, nama, nis, nisn, alamat, tgl_lahir, id_kelas) 
            VALUES ('$id', '$nama', '$nis', '$nisn', '$alamat', '$tgl_lahir', '$id_kelas')";
    
        if ($conn->query($sql) === TRUE) {
            echo "Siswa berhasil ditambahkan";
            // Redirect to prevent form resubmission
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$result = $conn->query("SELECT * FROM rentang_pekanan");
$rentang_pekanan = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rentang_pekanan[] = $row;
    }
}

$result_kelas = $conn->query("SELECT * FROM tb_kelas");
$kelas = [];
if ($result_kelas->num_rows > 0) {
    while ($row = $result_kelas->fetch_assoc()) {
        $kelas[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Tambah Rentang Pekanan & Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus rentang pekanan ini?");
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Tambah Rentang Pekanan</h1>
        <form method="post" action="">
            <input type="hidden" name="submit_rentang_pekanan" value="1">
            <div class="form-group">
                <label for="tgl_awal">Tanggal Awal:</label>
                <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" required>
            </div>
            <div class="form-group">
                <label for="tgl_akhir">Tanggal Akhir:</label>
                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" required>
            </div>
            <div class="form-group">
                <label for="pekan_ke">Pekan ke:</label>
                <input type="text" class="form-control" id="pekan_ke" name="pekan_ke" required>
            </div>
            <div class="form-group">
                <label for="bulan">Bulan:</label>
                <input type="text" class="form-control" id="bulan" name="bulan" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Rentang Pekanan</button>
        </form>
        <br><br>
        <hr>
        <h4 style="text-align:center;">Rentang Pekanan yang Telah Dibuat</h4>
        <table class="table">
            <thead>
                <tr class="primary">
                    <th>Tanggal Awal</th>
                    <th>Tanggal Akhir</th>
                    <th>Pekan ke</th>
                    <th>Bulan</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rentang_pekanan as $rentang) : ?>
                    <tr>
                        <td><?php echo isset($rentang['tgl_awal']) ? $rentang['tgl_awal'] : ''; ?></td>
                        <td><?php echo isset($rentang['tgl_akhir']) ? $rentang['tgl_akhir'] : ''; ?></td>
                        <td><?php echo isset($rentang['pekan_ke']) ? $rentang['pekan_ke'] : ''; ?></td>
                        <td><?php echo isset($rentang['bulan']) ? $rentang['bulan'] : ''; ?></td>
                        <td>
                            <form method="post" action="" onsubmit="return confirmDelete();">
                                <input type="hidden" name="delete_id" value="<?php echo $rentang['id']; ?>">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><br>
        <hr>
        <h1 class="mt-5">Tambah Siswa</h1>
        <form method="post" action="">
            <input type="hidden" name="submit_siswa" value="1">
            <div class="form-group">
                 <label for="id">ID Siswa:</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" class="form-control" id="nis" name="nis" required>
            </div>
            <div class="form-group">
                <label for="nisn">NISN:</label>
                <input type="text" class="form-control" id="nisn" name="nisn" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="tgl_lahir">Tanggal Lahir:</label>
                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
            </div>
            <div class="form-group">
                <label for="id_kelas">Kelas:</label>
                <select class="form-control" id="id_kelas" name="id_kelas" required>
                    <?php foreach ($kelas as $kls) : ?>
                        <option value="<?php echo $kls['id']; ?>"><?php echo $kls['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Siswa</button>
        </form>
        <br>
        <a href="tambah_ketua_kelas.php" class="btn btn-secondary">Tambah Ketua Kelas</a>
        <a href="tambah_kelas.php" class="btn btn-secondary">Tambah Kelas</a><br><br>
        <a href="logout.php" class="btn btn-primary">Logout</a><br><br>
    </div>
</body>
</html>