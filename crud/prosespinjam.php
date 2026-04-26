<?Php
session_start();
include("../connect.php");
$db = new database();

$userid = $_SESSION['user_id'];
$buku_id = $_POST['id_buku'];
$durasi = $_POST['durasi'];
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak");
}
if (!isset($_SESSION['user'])) {
        header('Location: ../user/login.php');
        exit;
    }

if ($durasi < 1 || $durasi > 30) {
    $_SESSION['err'] = 'Durasi Tidak Valid';
    header("Location: pinjam.php?id=$buku_id");
    exit();
}

$buku = $db->query("SELECT stok FROM buku WHERE id_buku = ?", [$buku_id])->fetch(PDO::FETCH_ASSOC);

if ($buku['stok'] <= 0) {
    $_SESSION["err"] = "Stock Telah Abis";
    header("Location: pinjam.php?id=$buku_id");
    exit();
}

$db->query(
    "INSERT INTO peminjaman 
    (user_id, buku_id, tanggal_pinjam, tgl_jatuh_tempo, status)
    VALUES (?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL ? DAY), ?)",
    [$userid, $buku_id, $durasi, 'dipinjam']       
);

$db->query("
UPDATE buku SET stok = stok - 1 WHERE id_buku = ?", [$buku_id]);

header("Location: ../table/index.php");

?>