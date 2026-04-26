    <?Php
    session_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../crud/style.css">
    </head>

    <body>
        <?Php
        include("../connect.php");
        if (!isset($_SESSION['user'])) {
            header('Location: ../user/login.php');
        }

        $db = new database();
        $id = $_GET['id'];

        $data = $db->query("SELECT * FROM user WHERE id = ?", [$id])->fetch(PDO::FETCH_ASSOC);

        ?>
        <form action="updatingproses.php" method="POST" enctype="multipart/form-data">
            <?php if (isset($_SESSION['err'])): ?>
                <p style="color: red;"><?= $_SESSION['err']; ?></p>
                <?php
                unset($_SESSION['err']);
            endif; ?>
            <input type="text" name="id" value="<?= $data['id'] ?>" placeholder="Masukkan Judul" hidden>
            <label for="username">Username</label>
            <br>
            <input type="text" name="username" value="<?= $data['username'] ?>" placeholder="Masukkan Judul">
            <br>
            <label for="password">Password</label>
            <br>
            <input type="text" name="password" placeholder="Edit Password ( Kosong Jika Tidak Perlu )">
            <br>
            <input type="submit">
            <a href="user.php" class="back">← Kembali</a>
        </form>
    </body>

    </html>