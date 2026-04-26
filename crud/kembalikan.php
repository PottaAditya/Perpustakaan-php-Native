<?php 
session_start();
include("../connect.php");
require_once("../auth/auth.php");
$id = $_GET["id"];
$userid = $_SESSION["user_id"];

$db = new database();
$d = new denda($db);
$data = $db->query(
    "SELECT buku_id FROM peminjaman WHERE id_pinjam = ? AND user_id = ? AND status = 'dipinjam'",
    [$id, $userid]
)->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    // data ga ketemu / bukan milik user / sudah dikembalikan
    header("Location: ../table/mybook.php");
    exit;
}

$idbuku = $data["buku_id"];

$d -> hitungDenda($id);

$db -> query("UPDATE peminjaman SET status = 'dikembalikan'  WHERE id_pinjam = ? AND user_id = ?", [$id, $userid]);

$db -> query("UPDATE buku SET stok = stok + 1 WHERE id_buku = ? ", [$idbuku]);

header("Location: ../table/mybook.php");

?>