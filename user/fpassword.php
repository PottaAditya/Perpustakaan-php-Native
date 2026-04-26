<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah User</title>
    <link rel="stylesheet" href="stylef.css">

    <style>

    </style>
</head>

<body>
    <form action="fproses.php" method="POST" class="card" id="formBuku" enctype="multipart/form-data">
        <h2>Forgot Password</h2>

        <?php if (isset($_SESSION['err'])): ?>
            <p style="color: red;">
                <?= $_SESSION['err']; ?>
            </p>
            <?php
            unset($_SESSION['err']);
        endif; ?>

        <div class="field">
            <input type="text" name="username" id="username" placeholder="Masukkan " required />
            <label for="username">Username</label>
        </div>

        <div class="field">
            <input type="text" name="password" id="password" placeholder=" " required />
            <label for="password">Password</label>
        </div>

        <div class="field">
            <input type="text" name="password2" id="password2" placeholder=" " required />
            <label for="password2">Konfirmasi Password</label>
        </div>

        <button type="submit" id="btnSubmit" name="add">Add User</button>
        <a href="login.php" class="back">← Kembali</a>
    </form>

    <script>
        const btn = document.getElementById("btnSubmit");
        const form = document.getElementById("formBuku");

        btn.addEventListener("click", function (e) {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            btn.style.setProperty("--x", x + "px");
            btn.style.setProperty("--y", y + "px");

            btn.classList.remove("ripple");
            void btn.offsetWidth;
            btn.classList.add("ripple");
        });


        form.addEventListener("submit", function (e) {
            const inputs = document.querySelectorAll("input");

            let adaKosong = false;

            inputs.forEach((i) => {
                if (i.type != "file" && i.value.trim() === "") {
                    adaKosong = true;
                }
            });

            if (adaKosong) {
                e.preventDefault();
                form.classList.add("shake");

                setTimeout(() => {
                    form.classList.remove("shake");
                }, 350);
            }
        });
    </script>
</body>

</html>