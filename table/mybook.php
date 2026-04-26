<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Peminjaman Buku</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            padding: 40px;
        }

        .container {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h2 {
            color: #1e293b;
        }

        .search {
            padding: 10px 15px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            outline: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #6366f1;
            color: white;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
        }

        tr:hover {
            background: #f1f5f9;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .pinjam {
            background: #fde68a;
            color: #92400e;
        }

        .kembali {
            background: #bbf7d0;
            color: #166534;
        }

        .back {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            transition: .3s;
        }

        .back:hover {
            color: #004a99;
        }

        .delete {
            background: #ff4d4d;
        }

        .delete:hover {
            background: #cc0000;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: .3s;
        }
    </style>
</head>
<?php

if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit;
}
include("../connect.php");


$db = new database();

$data = [];

$data = $db->query("
    SELECT 
        p.id_pinjam,
        b.judul_buku,
        p.tanggal_pinjam,
        p.tgl_jatuh_tempo
    FROM peminjaman p
    JOIN buku b ON p.buku_id = b.id_buku
    WHERE p.user_id = ?
    AND p.status = 'dipinjam'
    ORDER BY p.tanggal_pinjam DESC
", [
    $_SESSION['user_id']
])->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['cari'])) {
    $search = $_POST['nama'];
    $data = $db->query("SELECT 
                p.id_pinjam,
                u.username,
                b.judul_buku,
                p.tanggal_pinjam,
                p.tgl_jatuh_tempo,
                DATEDIFF(p.tgl_jatuh_tempo, CURDATE()) AS sisa_hari,
                p.status,
                p.denda
            FROM peminjaman p
            JOIN user u ON p.user_id = u.id
            JOIN buku b ON p.buku_id = b.id_buku
            WHERE p.user_id = ?
            AND p.status = 'dipinjam'
            AND b.judul_buku LIKE ?
            ORDER BY p.tanggal_pinjam DESC; 
            ", [
        $_SESSION['user_id'],
        "%$search%"
    ])->fetchAll(PDO::FETCH_ASSOC);
}

?>

<body>

    <div class="container">
        <div class="header">
            <h2>📚 Data Peminjaman Buku</h2>
            <form action="" method="POST">
                <input type="text" name="nama" placeholder="Search user...">
                <input type="submit" name="cari">
            </form>
        </div>
        <a href="../home.php" class="back">Kembali</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                        <td><?= htmlspecialchars($row['tgl_jatuh_tempo']) ?></td>
                        <td><a href="../crud/kembalikan.php?id=<?= $row['id_pinjam'] ?>" class="btn delete">Kembalikan</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (isset($_POST['cari'])): ?>
            <a href="mybook.php" class="back">← Balik</a>
        <?php endif; ?>
    </div>

</body>

</html>