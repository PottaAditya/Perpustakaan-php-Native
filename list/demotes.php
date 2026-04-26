<?php
include('../connect.php');

require_once("../auth/auth.php");
require_once("../auth/session.php");

$data = $db -> query("SELECT role FROM user WHERE id = ?",
[$_SESSION['user_id']])->fetch(PDO::FETCH_ASSOC);

$id = $_GET['id'];

if ($data['role'] !== 'admin') {
    $_SESSION['role'] = 'user';
    header("Location: ../home.php");
    exit;
}

$Demote = new Auth($db);
$Demote->Demotes($id);
header("Location: admin.php");
?>