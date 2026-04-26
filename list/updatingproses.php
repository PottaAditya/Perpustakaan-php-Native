<?php

require_once("../auth/session.php");
require_once("../auth/auth.php");

$usn = $_POST['username'];
$id = $_POST['id'];
$password = trim($_POST['password']);

$target = $db->query(
    "SELECT role FROM user WHERE id = ?",
    [$id]
)->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['role'] = 'user';
    header("Location: ../home.php");
    exit;
}

$update = new update($db);
$result = $update->updates($usn, $password, $id);


if ($result === 'PASSWORD_SAME') {
    $_SESSION['err'] = 'Password tidak boleh sama dengan yang lama';
    header("Location: updating.php?id=$id");
    exit;
}

if ($result === 'USER_NOT_FOUND') {
    $_SESSION['err'] = 'User tidak ditemukan';
    header("Location: updating.php?id=$id");
    exit;
}

if ($result === 'USERNAME_TAKEN') {
    $_SESSION['err'] = 'Username Telah Terpakai';
    header("Location: updating.php?id=$id");
    exit;
}

$redirect = $target['role'] === 'admin'
    ? 'admin.php'
    : 'user.php';

header("Location: $redirect");
exit;




?>