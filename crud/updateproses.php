<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit;
}

include("../connect.php");
$db = new database();

$id = $_POST["id"];
$jb = $_POST["jb"];
$pg = $_POST["pg"];
$tb = $_POST["tb"];
$stok = $_POST["stok"];
$tahunwajar = date('Y');

if (!is_numeric($tb)) {
    $_SESSION['err'] = "Tahun harus angka";
    header("Location: formupdate.php?id=$id");
    exit;
}

if ($tb > $tahunwajar || $tb < 1200) {
    $_SESSION['err'] = "Tahun Tidak Wajar";
    header("location: formupdate.php?id=$id");
    exit;
}

// ambil data lama
$old = $db->query("SELECT gambar FROM buku WHERE id_buku = ?", [$id])->fetch(PDO::FETCH_ASSOC);
$oldFile = $old['gambar'];

$newname = $oldFile;
// cek apakah user mengupload files atau tidak
if (isset($_FILES['folder']) && $_FILES['folder']['error'] === 0) {

    $files = $_FILES['folder'];
    // nama files
    $namefiles = $files['name'];
    // tempat penyimpanan sementara
    $tmp = $files['tmp_name'];
    // arah folder
    $folders = '../table/gambar/';
    // agar nama + time ga jadi sama misal 17000_sukuna, 1800000_gojo
    $newname = time() . '_' . $namefiles;

    $mine = ['images/jpg', 'images/png'];
    $ext = ['jpg', 'png'];

    $mine = mime_content_type($tmp);
    if (!in_array($mine, $ext)) {
        $_SESSION['err'] = 'Error File Harus Berupa PNG / JPG';
        header("Location: formupdate.php?id=$id");
        exit;
    }

    // HAPUS GAMBAR LAMA
    if (file_exists($folders . $oldFile)) {
        unlink($folders . $oldFile);
    }

    // UPLOAD GAMBAR BARU
    move_uploaded_file($tmp, $folders . $newname);
}



// UPDATE DATA
$db->query(
    "UPDATE buku SET judul_buku=?, pengarang=?, tahun_terbit=?, gambar=?, stok=? WHERE id_buku=?",
    [$jb, $pg, $tb, $newname, $stok, $id]
);

header("Location: ../table/index.php");
exit;
?>