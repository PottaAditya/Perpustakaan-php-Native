<?Php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?Php
    include("../connect.php");
    if (!isset($_SESSION['user'])) {
        header('Location: ../user/login.php');
    }

    $db = new database();
    $id = $_GET['id'];

    $data = $db->query("SELECT * FROM buku WHERE id_buku = ?", [$id])->fetch(PDO::FETCH_ASSOC);

    ?>
    <form action="updateproses.php" method="POST" enctype="multipart/form-data">
        <?php if (isset($_SESSION['err'])): ?>
            <p style="color: red;"><?= $_SESSION['err']; ?></p>
            <?php
            unset($_SESSION['err']);
        endif; ?>
        <input type="text" name="id" value="<?= $data['id_buku'] ?>" placeholder="Masukkan Judul" hidden>
        <label for="jb">Judul Buku</label>
        <br>
        <input type="text" name="jb" value="<?= $data['judul_buku'] ?>" placeholder="Masukkan Judul">
        <br>
        <label for="pg">Pengarang</label>
        <br>
        <input type="text" name="pg" value="<?= $data['pengarang'] ?>" placeholder="Masukkan Pengarang">
        <br>
        <label for="tb">Tahun Terbit</label>
        <br>
        <input type="text" name="tb" value="<?= $data['tahun_terbit'] ?>" placeholder="Masukkan Tahun">
        <br>
        <label for="stok">stock</label>
        <br>
        <input type="text" name="stok" value="<?= $data['stok'] ?>">
        <br>
        <label for="folder" class="file-label">Upload Gambar</label>
        <br>
        <input type="file" name="folder" id="folder" />
        <br>
        <input type="submit">
        <a href="../table/index.php" class="back">← Kembali</a>
    </form>
</body>

</html>