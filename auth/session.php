<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit;
}
require_once('../connect.php');
$db = new database();

$data = $db->query(
    "SELECT role FROM user WHERE id = ?",
    [$_SESSION['user_id']]
)->fetch(PDO::FETCH_ASSOC);

?>