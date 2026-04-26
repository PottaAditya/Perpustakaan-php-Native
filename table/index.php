<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <?php
    include("../connect.php");
    $db = new database();

    if (!isset($_SESSION['user'])) {
        header('Location: ../user/login.php');
        exit;
    }
    $nama = $_SESSION['user'];

    $data = $db->query("SELECT * FROM buku")->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST["search"])) {
        $search = $_POST["cari"];
        $data = $db->query("SELECT * FROM buku
                        WHERE pengarang LIKE ?
                        OR judul_buku LIKE ?
                        OR tahun_terbit LIKE ?",
            ["%$search%", "%$search%", "%$search%"]
        )->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Buku</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="container fade-in">

            <h1 class="title">📚 Daftar Buku Perpustakaan</h1>
            <p class="sub">Selamat Datang <strong><?= $nama ?></strong></p>

            <form action="" method="POST" class="search-box">
                <input type="text" id="searchBuku" name="cari" placeholder="Cari buku..." autocomplete="off" id="po">
                <button name="search">Cari</button>
                <ul id="listBuku" class="suggest-box"></ul>
            </form>

            <div class="actions">
                <a href="../home.php" class="back">← Balik</a>
                <a href="../crud/formtambah.php" class="btn primary">Tambah Buku</a>

            </div>

            <table class="table fade-up">
                <tr>
                    <th>NO</th>
                    <th>JUDUL</th>
                    <th>PENGARANG</th>
                    <th>TAHUN</th>
                    <th>Gambar</th>
                    <th>Stock</th>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <th>UPDATE</th>
                        <th>DELETE</th>
                        <?php endif; ?>
                        <th>PINJAM</th>
                </tr>

                <?php $no = 1;
                foreach ($data as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['judul_buku'])?></td>
                        <td><?= htmlspecialchars($row['pengarang']) ?></td>
                        <td><?= htmlspecialchars($row['tahun_terbit']) ?></td>
                        <td><img src="gambar/<?= htmlspecialchars($row['gambar']) ?>" width="120px"></td>
                        <td><?= htmlspecialchars($row['stok']) ?></td>

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <td><a href="../crud/formupdate.php?id=<?= $row['id_buku'] ?>" class="link update">Update</a></td>
                            <td><a href="../crud/delete.php?id=<?= $row['id_buku'] ?>" class="link delete">Delete</a></td>
                            <?php endif; ?>
                            <td><a href="../crud/pinjam.php?id=<?= $row['id_buku']?>" class="btn pinjam">Pinjam</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php if (isset($_POST['search'])): ?>
                <a href="index.php" class="back">← Balik</a>
            <?Php endif; ?>
        </div>
        <p id="pos"></p>

    </body>

    </html>


</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(function () {
        $(".link.delete").click(function (e) {
            if (!confirm("Yakin Ingin Menghapus?")) {
                e.preventDefault();
            }
        })
    })
</script>

</html>