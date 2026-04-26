<?php

require_once("../auth/session.php");
require_once("../auth/auth.php");

$id = $_GET['id'];

$target = $db->query(
    "SELECT role FROM user WHERE id = ?",
    [$id]
)->fetch(PDO::FETCH_ASSOC);

if (!$target) {
    header("Location: admin.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['role'] = 'user';
    header("Location: ../home.php");
    exit;
}

if ($_SESSION['user_id'] == $id) {
    $_SESSION['err'] = "SELF DELETE";
    header("Location: admin.php");
    exit;
}

$deleteUser = new DeleteUser($db);
$deleteUser->delete($id);

$redirect = $target['role'] === 'admin'
    ? 'admin.php'
    : 'user.php';

header("Location: $redirect");
exit;

?>