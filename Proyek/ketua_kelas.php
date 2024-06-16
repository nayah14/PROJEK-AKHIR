<?php
    include('session.php');

    if (!isKetuaKelas()) {
        header("location: login.php");
        exit;
    }

    include('db.php');

    $ketua_kelas_id = $_SESSION['user_id'];

    // Mengambil rentang pekanan yang berlaku
    // $sql_rentang= "
    //     SELECT rentang_pekanan.*
    //     FROM rentang_pekanan
    //     WHERE rentang_pekanan.tgl_awal AND rentang_pekanan.tgl_akhir
    // ";

    $sql_rentang = "SELECT * FROM rentang_pekanan";

    $result = $conn->query($sql_rentang);
    $pekan = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pekan[] = $row;
        }
    }

    $rentang_pekanan_result = $conn->query($sql_rentang);
    if ($rentang_pekanan_result->num_rows == 0) {
        echo "Tidak ada rentang pekanan untuk minggu ini.";
        exit;
    }

    $rentang_pekanan = $rentang_pekanan_result->fetch_assoc();
    $tgl_awal = $rentang_pekanan['tgl_awal'];
    $tgl_akhir = $rentang_pekanan['tgl_akhir'];

    // Mengambil tanggal dalam rentang pekanan
    $dates = [];
    $start = new DateTime($tgl_awal);
    $end = new DateTime($tgl_akhir);
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($start, $interval, $end->modify('+1 day'));

    foreach ($daterange as $date) {
        $dates[] = $date->format("Y-m-d");
    }

    // Mengambil data siswa untuk ketua kelas
    $sql_siswa = "
        SELECT siswa.id, siswa.nama, siswa.nis, siswa.nisn, siswa.alamat, siswa.tgl_lahir, tb_kelas.nama AS nama_kelas 
        FROM siswa 
        INNER JOIN tb_kelas ON siswa.id_kelas = tb_kelas.id 
        INNER JOIN ketua_kelas ON tb_kelas.id_ketua_kelas = ketua_kelas.id 
        WHERE ketua_kelas.id = '$ketua_kelas_id'
    ";
    $siswa_result = $conn->query($sql_siswa);

    // Ambil data kelas
    $sql_kelas = "
        SELECT nama
        FROM tb_kelas
        WHERE id_ketua_kelas = '$ketua_kelas_id'
    ";
    $kelas_result = $conn->query($sql_kelas);
    if ($kelas_result->num_rows > 0) {
        $row = $kelas_result->fetch_assoc();
        $class = $row['nama'];
    } else {
        $class = "Kelas tidak ditemukan"; // Atur pesan default jika kelas tidak ditemukan
    }

    // Proses pengiriman data absensi
    $success = false;
    if (isset($_POST['submit_attendance'])) {
        $id_siswa = $_POST['id_siswa'];
        $tanggal = $_POST['tanggal'];
        $status = $_POST['status'];
        $deskripsi = $_POST['deskripsi'];

        foreach ($id_siswa as $index => $id) {
            $date = $tanggal[$index];
            $state = $status[$index];
            $desc = $deskripsi[$index];

            // Cek apakah data absensi sudah ada untuk tanggal yang sama
            $check_sql = "
                SELECT * FROM absensi 
                WHERE id_siswa = '$id' AND tanggal = '$date'
            ";
            $check_result = $conn->query($check_sql);
            if ($check_result->num_rows == 0) {
                $insert_sql = "
                    INSERT INTO absensi (id_siswa, tanggal, status, deskripsi) 
                    VALUES ('$id', '$date', '$state', '$desc')
                ";
                if ($conn->query($insert_sql) === TRUE) {
                    $success = true;
                } else {
                    echo "Error: " . $insert_sql . "<br>" . $conn->error;
                }
            } else {
                echo "Data absensi untuk siswa $id pada tanggal $date sudah ada.<br>";
            }
        }

        if ($success) {
            echo "<script>alert('Data absensi berhasil disimpan.');</script>";
        }
        }
    ?>


    <!DOCTYPE html>
    <html>
    <head>
        <title>Ketua Kelas - Input Absensi</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <style>
            body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        margin-top: 50px;
    }

    h1 {
        color: #007bff;
    }

    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table thead th {
        background-color: #007bff;
        color: white;
    }

    .tanggal-btn {
        width: 100%;
        margin-bottom: 10px;
    }

    #siswa-container {
        margin-top: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    select.form-control {
        width: 100%;
    }

    input.form-control {
        width: 100%;
    }

    .logout-btn {
        margin-top: 20px;
    }

        </style>
    </head>
    <body>
    
        <div class="container">
            
            <h1 class="mt-5">Input Absensi Pekanan untuk Kelas <?php echo $class; ?></h1><br><br>
            <?php foreach ($pekan as $re): ?>
            <div class="alert alert-info">
                <strong>Pekan ke-<?= $re['pekan_ke'] ?> Bulan <?= $re['bulan'] ?></strong>
                <br>
            </div>  
            <form method="post" action="">
                <?php
                // Mengambil tanggal dalam rentang pekanan
                $dates = [];
                $start = new DateTime($re['tgl_awal']);
                $end = new DateTime($re['tgl_akhir']);
                $interval = new DateInterval('P1D');
                $daterange = new DatePeriod($start, $interval, $end->modify('+1 day'));

                foreach ($daterange as $date) {
                    $dates[] = $date->format("Y-m-d");
                }
                ?>
                <div class="form-group">
                    <label for="tanggal">Tanggal:</label><br><br>
                    <div class="row">
                        <?php foreach ($dates as $date): ?>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary tanggal-btn" data-date="<?php echo $date; ?>"><?php echo $date; ?></button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="siswa-container" style="display: none;">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>NISN</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $siswa_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['nisn']; ?></td>
                                <td>
                                    <input type="hidden" name="id_siswa[]" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="tanggal[]" value="">
                                    <select class="form-control" name="status[]">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Alfa">Alfa</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="deskripsi[]"></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <button type="submit" name="submit_attendance" class="btn btn-primary">Rekam Absensi</button><br><br>
                </div>
            </form>
        <?php endforeach; ?><br>

            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
        <script>
            document.querySelectorAll('.tanggal-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const date = button.getAttribute('data-date');
                    document.querySelectorAll('input[name="tanggal[]"]').forEach(input => {
                        input.value = date;
                    });
                    document.getElementById('siswa-container').style.display = 'block';
                });
            });
        </script>
    </body>
    </html>
