<?php
session_start();
include("../connect.php");

$db = new database();
$error = false;

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->query('SELECT * FROM user WHERE username = ?', [$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];
        header('Location: ../home.php');
        exit;
    } else {
        $error = true;
    }
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container fade-in">
        <form action="" method="POST" class="card">

            <h2>Login</h2>

            <?php if ($error): ?>
                <p class="error">Username atau Password salah!</p>
            <?php endif; ?>

            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>

            <button name="login">Login</button>

            <a href="regis.php" class="regis">Belum punya akun?</a>
            <a href="fpassword.php" class="regis">Forgot Password?</a>
        </form>
    </div>
</body>

</html>