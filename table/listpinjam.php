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
    </style>
</head>
<?php 
session_start();
if (!isset($_SESSION['user'])) {
        header('Location: ../user/login.php');
        exit;
    }

include("../connect.php");
$db = new database();
$data = $db->query("SELECT 
    p.id_pinjam,
    u.username,
    b.judul_buku,
    p.tanggal_pinjam,
    p.tgl_jatuh_tempo,
    DATEDIFF(p.tgl_jatuh_tempo, CURDATE()) AS sisa_hari,
    p.status
FROM peminjaman p
JOIN user u ON p.user_id = u.id
JOIN buku b ON p.buku_id = b.id_buku
ORDER BY p.tanggal_pinjam DESC;
")->fetchAll(PDO::FETCH_ASSOC);


?>

<body>

    <div class="container">
        <div class="header">
            <h2>📚 Data Peminjaman Buku</h2>
            <input type="text" class="search" placeholder="Cari user / buku...">
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($data as $row):?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['judul_buku'] ?></td>
                    <td><?= $row['tanggal_pinjam'] ?></td>
                    <td><?= $row['tgl_jatuh_tempo'] ?></td>
                    <?php if($row ['status'] === 'dipinjam'): ?>
                    <td><span class="badge pinjam"><?= $row['status'] ?></span></td>
                    <?php else: ?>
                    <td><span class="badge kembali"><?= $row['status']?></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <a href="../home.php" class="back">← Balik</a>
    </div>

</body>

</html>