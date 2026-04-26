<?php
session_start();
include "../connect.php";

$id = $_GET['id'];
$db = new database();

if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak");
}

if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit;
}

$data = $db->query(
    "SELECT * FROM buku WHERE id_buku = ?",
    [$id]
)->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pinjam Buku</title>

    <style>
        body {
            background: #f4f6f9;
            font-family: "Poppins", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 30px 35px;
            border-radius: 12px;
            width: 380px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-size: 14px;
            color: #555;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            outline: none;
        }

        input[readonly] {
            background: #f0f0f0;
        }

        input:focus,
        select:focus {
            border-color: #4f46e5;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #4338ca;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #4f46e5;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Form Pinjam Buku</h2>

    <?php if (isset($_SESSION['err'])): ?>
        <div class="error"><?= $_SESSION['err']; ?></div>
        <?php unset($_SESSION['err']); ?>
    <?php endif; ?>

    <form action="prosespinjam.php" method="post">
        <input type="hidden" name="id_buku" value="<?= $data['id_buku']; ?>">

        <label>Nama Buku</label>
        <input type="text" value="<?= $data['judul_buku']; ?>" readonly>

        <br><br>

        <label>Lama Pinjam</label>
        <select name="durasi" required>
            <option value="3">3 Hari</option>
            <option value="7">7 Hari</option>
            <option value="14">14 Hari</option>
            <option value="30">30 Hari</option>
        </select>

        <br><br>

        <input type="submit" value="Pinjam Buku">
    </form>

    <a href="../table/index.php">← Kembali</a>
</div>

</body>
</html>
