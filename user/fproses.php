<?php 
session_start();
include("../connect.php");
require_once('../auth/auth.php');

$username  = $_POST['username'];
$password  = $_POST['password'];
$password2 = $_POST['password2'];

$db = new database();
$forgot = new update($db);
$result = $forgot->fpassword($username, $password, $password2);

if ($result === 'USERNAME_NOT_FOUND') {
    $_SESSION['err'] = 'Username tidak ditemukan';
    header('Location: fpassword.php');
    exit;
}

if ($result === 'PASSWORD_NOT_MATCH') {
    $_SESSION['err'] = 'Password tidak sama';
    header('Location: fpassword.php');
    exit;
}

header('Location: login.php');
exit;



?>