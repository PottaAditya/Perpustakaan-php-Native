<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include("../connect.php");
    $db = new database();

    if ($_SESSION['role'] !== 'admin') {
        header("Location: ../home.php");
        exit;
    }

    if (!isset($_SESSION['user'])) {
        header('Location: ../user/login.php');
        exit;
    }

    $data = $db->query("SELECT * FROM user WHERE role = 'user' ")->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_POST["cari"])) {
        $cari = $_POST["nama"];
        $data = $db->query(
            "SELECT * FROM user WHERE role = 'user' and username like ? or id like ?",
            ["%$cari%", "%$cari%"]
        );
    }
    ?>

    <div class="dashboard">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <h2>User List</h2>
            <ul>
                <li class="active">Users</li>
                <?Php if (isset($_POST["cari"])): ?>
                    <li><a href="user.php">Back</a></li>
                <?Php endif; ?>
                <li><a href="../home.php">Back To Home</a></li>
            </ul>
        </aside>

        <!-- MAIN -->
        <main class="main">
            <header class="header">
                <h1>User Management</h1>
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Search user...">
                    <input type="submit" name="cari">
                </form>

            </header>

            <section class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <th>Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data as $user): ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td><?= $user['id']; ?></td>
                                <td><?= htmlspecialchars($user['username']); ?></td>
                                <td><?= htmlspecialchars($user['role']); ?></td>
                                <td>
                                    <div class="actions">
                                        <?php if ($_SESSION['role'] === 'admin'): ?>
                                            <a class="btn edit" href="updating.php?id=<?= $user['id']; ?>">Edit</a>
                                            <a href="promoting.php?id=<?= $user['id'] ?>" class="btn add">Jadikan Admin</a>
                                            <a class="btn delete" href="deletes.php?id=<?= $user['id']; ?>">Delete</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                <script>$(function () {
                        $(".btn.delete").click(function (e) {
                            if (!confirm('Yakin Ingin Menghapus?')) {
                                e.preventDefault();
                            }
                        })
                    })

                </script>
</body>
<a href="../user/AddU.php" class="btn add">Add User</a>

</html>