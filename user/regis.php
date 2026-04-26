<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<?php
require_once("../connect.php");
require_once("function.php");
$db = new database();
$user = new user($db);

$err = "";

if (isset($_POST["register"])) {
    $result = $user->regis($_POST);

    if ($result === true) {
        header("Location: login.php");
        exit;
    } else {
        $err = $result;
    }
}
?>

<body>

    <div class="container fade-in">
        <form action="" method="POST" class="card" id="registerForm">
            <p id="error"></p>

            <h2>Register</h2>

            <?php if ($err): ?>
                <p class="error" id="errorBox"><?= $err ?></p>
            <?php endif; ?>

            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" id="user">

            <label>Password</label>
            <div style="position: relative;">
                <input type="password" name="password" id="password" required placeholder="Masukkan password">
                <span id="togglePass" class="eye">👁️</span>
            </div>

            <button name="register" id="registerBtn">Register</button>

            <a href="login.php" class="regis">Sudah punya akun?</a>
        </form>
    </div>
</body>

</script>

</html>