<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit;
}

require_once("../auth/session.php");
require_once("../auth/auth.php");

$data = $db -> query("SELECT role FROM user WHERE id = ?",
[$_SESSION['user_id']])->fetch(PDO::FETCH_ASSOC);

$id = $_GET['id'];

if ($data['role'] !== 'admin') {
    $_SESSION['role'] = 'user';
    header("Location: ../home.php");
    exit;
}

$promotes = new Auth($db);
$promotes->promoting($id);

header("Location: user.php");
exit;
?>