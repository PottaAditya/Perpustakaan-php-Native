<?php

require_once("../connect.php");
require_once("function.php");
require_once("../auth/session.php");

$db = new database();
$user = new user($db);
$err = "";

if (isset($_POST['add'])) {
    $result = $user->registrasi($_POST);
    
    if ($result === true) {
        header("Location: ../list/user.php");
        exit;
    } else {
        $err = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah User</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e293b, #334155, #475569);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            animation: bgMove 20s linear infinite;
        }

        @keyframes bgMove {
            0% { background-position: 0 0; }
            50% { background-position: 200% 100%; }
            100% { background-position: 0 0; }
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(14px);
            padding: 30px;
            width: 360px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: zoomIn 0.6s ease;
            position: relative;
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
            letter-spacing: 1px;
            font-weight: 600;
            text-shadow: 0 2px 8px rgba(0,0,0,0.5);
        }

        .field {
            margin-bottom: 20px;
            position: relative;
        }

        .field label {
            position: absolute;
            top: 12px;
            left: 12px;
            font-size: 14px;
            color: #e2e8f0;
            opacity: 0.7;
            transition: 0.25s;
            pointer-events: none;
        }

        input, select {
            width: 100%;
            padding: 14px 12px;
            border-radius: 10px;
            border: none;
            background: rgba(255,255,255,0.2);
            color: white;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        input:focus, select:focus {
            background: rgba(255,255,255,0.35);
            box-shadow: 0 0 10px #38bdf8;
        }

        input:focus + label,
        input:not(:placeholder-shown) + label,
        select:focus + label,
        select:not([value=""]) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #7dd3fc;
            opacity: 1;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg width='10' height='5' viewBox='0 0 10 5' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='white' d='M0 0l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px 6px;
            padding-right: 40px;
        }

        select option {
            color: #000;
            background: #fff;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #0ea5e9;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        button:hover {
            background: #0284c7;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        button::after {
            content: "";
            position: absolute;
            background: rgba(255,255,255,0.6);
            width: 0;
            height: 0;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            pointer-events: none;
        }

        button.ripple::after { animation: ripple 0.4s ease-out; }

        @keyframes ripple {
            from { width: 0; height: 0; opacity: 1; }
            to { width: 300px; height: 300px; opacity: 0; }
        }

        .shake { animation: shakeAnim 0.3s ease; }

        @keyframes shakeAnim {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }

        .back {
            display: block;
            margin-top: 25px;
            text-decoration: none;
            color: #8f9caa;
            font-weight: 500;
            text-align: center;
            transition: 0.3s;
        }

        .back:hover { color: #fff; text-decoration: underline; }

        .error {
            background: rgba(255,0,0,0.2);
            color: #ff4d4d;
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body>
    <form action="" method="POST" class="card" id="formBuku" enctype="multipart/form-data">
        <h2>Add User</h2>

        <?php if ($err): ?>
            <p class="error"><?= $err ?></p>
        <?php endif; ?>

        <div class="field">
            <input type="text" name="username" id="username" placeholder=" " required />
            <label>Username</label>
        </div>

        <div class="field">
            <input type="text" name="password" id="password" placeholder=" " required />
            <label>Password</label>
        </div>

        <div class="field">
            <select name="role" required>
                <option value="" disabled selected hidden></option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <label>Role</label>
        </div>

        <button type="submit" id="btnSubmit" name="add">Add User</button>
        <a href="../list/user.php" class="back">← Kembali</a>
    </form>

    <script>
        const btn = document.getElementById("btnSubmit");
        const form = document.getElementById("formBuku");

        btn.addEventListener("click", function(e) {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            btn.style.setProperty("--x", x + "px");
            btn.style.setProperty("--y", y + "px");

            btn.classList.remove("ripple");
            void btn.offsetWidth;
            btn.classList.add("ripple");
        });

        form.addEventListener("submit", function(e) {
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
                setTimeout(() => { form.classList.remove("shake"); }, 350);
            }
        });
    </script>
</body>
</html>
