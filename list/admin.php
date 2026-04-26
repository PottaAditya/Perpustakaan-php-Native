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
    include("../user/function.php");
    $db = new database();

    $user = new user($db);
    $user->updateSesi();

    if (!isset($_SESSION['user'])) {
        header('Location: ../user/login.php');
        exit;
    }
    if ($_SESSION['role'] !== 'admin') {
        header("Location: ../home.php");
        exit;
    }

    $data = $db->query("SELECT * FROM user WHERE role = 'admin'")->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_POST["cari"])) {
        $cari = $_POST["nama"];
        $data = $db->query(
            "SELECT * FROM user WHERE role = 'admin' and (username like ? or id like ?)",
            ["%$cari%", "%$cari%"]
        )->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>

    <div class="dashboard">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <h2>Admin</h2>
            <ul>
                <li class="active">Users</li>
                <?Php if (isset($_POST["cari"])): ?>
                    <li><a href="admin.php">Back</a></li>
                <?Php endif; ?>
                <li><a href="../home.php">Back To Home</a></li>
            </ul>
        </aside>

        <!-- MAIN -->
        <main class="main">
            <header class="header">
                <h1>User Management</h1>
                <?php if (isset($_SESSION['err'])): ?>
                    <p style="color:red">
                        <?= $_SESSION['err']; ?>
                    </p>
                    <?php unset($_SESSION['err']); ?>
                <?php endif; ?>
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
                            <th>Action</th>
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
                                        <a class="btn edit" href="demotes.php?id=<?= $user['id']; ?>">Demote</a>
                                        <a class="btn delete" href="deletes.php?id=<?= $user['id']; ?>">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>

    </div>

</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>$(function () {
        $(".btn.delete").click(function (e) {
            if (!confirm('Yakin Ingin Menghapus?')) {
                e.preventDefault();
            }
        })
    })

</script>

</html>