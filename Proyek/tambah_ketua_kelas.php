<?php
include('session.php');

if (!isAdmin()) {
    echo "bukan ketua kelas";
    exit;
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_ketua_kelas'])) {
        $delete_id = $_POST['delete_ketua_kelas'];
        $stmt = $conn->prepare("DELETE FROM ketua_kelas WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute() === TRUE) {
            echo "<script>alert('Ketua Kelas berhasil dihapus'); window.location.href = 'tambah_ketua_kelas.php';</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['edit_ketua_kelas'])) {
        $edit_id = $_POST['edit_id'];
        $username = $_POST['username'] ?? '';
        $name = $_POST['Name'] ?? '';
        $password = $_POST['password'] ?? '';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE ketua_kelas SET username = ?, Name = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $name, $hashed_password, $edit_id);
        if ($stmt->execute() === TRUE) {
            echo "<script>alert('Ketua Kelas berhasil diupdate'); window.location.href = 'tambah_ketua_kelas.php';</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['submit_ketua_kelas'])) {
        $username = $_POST['username'] ?? '';
        $name = $_POST['name'] ?? '';
        $password = $_POST['password'] ?? '';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT * FROM ketua_kelas WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "Username sudah ada";
        } else {
            $stmt = $conn->prepare("INSERT INTO ketua_kelas (username, Name, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $name, $hashed_password);
            if ($stmt->execute() === TRUE) {
                echo "<script>alert('Ketua Kelas berhasil ditambahkan'); window.location.href = 'tambah_ketua_kelas.php';</script>";
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

$result_ketua_kelas = $conn->query("SELECT * FROM ketua_kelas");
$ketua_kelas = [];
if ($result_ketua_kelas->num_rows > 0) {
    while ($row = $result_ketua_kelas->fetch_assoc()) {
        $ketua_kelas[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Ketua Kelas</title>
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
        color: black;
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
    </style>
    <div class="container">
        <h1 class="mt-5">Tambah Ketua Kelas</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" class="form-control" id="Name" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_ketua_kelas">Tambah Ketua Kelas</button>
        </form>

        <h2 class="mt-5">Daftar Ketua Kelas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ketua_kelas as $ketua): ?>
                    <tr>
                        <td><?php echo $ketua['username']; ?></td>
                        <td><?php echo $ketua['Name']; ?></td>
                        <td>
                            <form method="post" action="" style="display:inline-block;">
                                <input type="hidden" name="delete_ketua_kelas" value="<?php echo $ketua['id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ketua kelas ini?');">Hapus</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal<?php echo $ketua['id']; ?>">Edit</button>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?php echo $ketua['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Ketua Kelas</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="">
                                            <div class="modal-body">
                                                <input type="hidden" name="edit_id" value="<?php echo $ketua['id']; ?>">
                                                <div class="form-group">
                                                    <label for="username">Username:</label>
                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $ketua['username']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Name">Name:</label>
                                                    <input type="text" class="form-control" id="name" name="Name" value="<?php echo $ketua['Name']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password:</label>
                                                    <input type="password" class="form-control" id="password" name="password" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="edit_ketua_kelas">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Edit Modal -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
