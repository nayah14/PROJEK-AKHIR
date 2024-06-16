<?php
include('session.php');

if (!isAdmin()) {
    header("location: login.php");
    exit;
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $id_ketua_kelas = $_POST['id_ketua_kelas'];

    $sql = "SELECT id FROM tb_kelas WHERE id_ketua_kelas = $id_ketua_kelas";
    if($conn->query($sql)->num_rows > 0){
        echo "<script>alert('Ketua Kelas Sudah Menjabat')</script>";
    }else{

        
        $sql = "INSERT INTO tb_kelas (nama, id_ketua_kelas) VALUES ('$nama', '$id_ketua_kelas')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Kelas berhasil ditambahkan";
    header("Location: tambah_kelas.php");
exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
}

$result_ketua = $conn->query("SELECT id, nama FROM ketua_kelas");
$ketua_kelas = [];
if ($result_ketua->num_rows > 0) {
    while ($row = $result_ketua->fetch_assoc()) {
        $ketua_kelas[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Tambah Kelas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <style>
.container {
    padding: 30px;
    background-color: antiquewhite;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

form {
    margin-bottom: 30px;
}

.form-group label {
    font-weight: bold;
    color: #555;
}

.form-control {
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
}

.btn {
    margin: 5px;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004080;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    transition: background-color 0.3s ease;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #4e555b;
}

    </style>
    <div class="container">
        <h1 class="mt-5">Tambah Kelas</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="nama">Nama Kelas:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="id_ketua_kelas">Ketua Kelas:</label>
                <select class="form-control" id="id_ketua_kelas" name="id_ketua_kelas">
                    <?php foreach ($ketua_kelas as $ketua) : ?>
                        <option value="<?php echo $ketua['id']; ?>"><?php echo $ketua['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Kelas</button>
        </form>
        <br>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>