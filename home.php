<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {

            --bs-primary: #0F172A;
            --bs-primary-rgb: 15, 23, 42;


            --bs-secondary: #F1F5F9;
            --bs-secondary-rgb: 241, 245, 249;

            --bs-body-color: #0F172A;
        }

        body {
            background-color: var(--bs-secondary);
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: .375rem;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-radius: .375rem;
        }

        .fs-7 {
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }


        .content-card {
            background: #FFFFFF;
            color: #0F172A;
        }
    </style>
</head>

<body>
    <?php session_start(); ?>
    <?php
    if (!isset($_SESSION['user'])) {
        header('Location: user/login.php');
        exit;
    }
    include("connect.php");
    include("user/function.php");
    $db = new database();

    $user = new user($db);
    $user->updateSesi();

    $data = $db->query(
        "SELECT role FROM user WHERE id = ?",
        [$_SESSION['user_id']]
    )->fetch();

    if ($data && $_SESSION['role'] !== $data['role']) {
        $_SESSION['role'] = $data['role'];
    }
    $nama = $_SESSION['user'];
    ?>
    <div class="d-flex vh-100">


        <div class="p-3 bg-primary text-white" style="width: 270px;">
            <div class="mb-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-activity fs-2 me-3"></i>
                <div class="h3 text-secondary m-2">Universe</div>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="home.php"
                        class="nav-link d-flex text-white text-decoration-none fs-5 fw-semibold gap-2 active">
                        <i class="bi bi-house"></i>
                        Home
                    </a>
                </li>

                <li class="nav-item px-3 mt-3 text-white-50 fs-7 text-uppercase">Buku</li>

                <li class="nav-item">
                    <a href="table/table.php"
                        class="nav-link d-flex text-white text-decoration-none fs-5 fw-semibold gap-2">
                        <i class="bi bi-book"></i>
                        Daftar Buku
                    </a>
                </li>

                <li class="nav-item">
                    <a href="mybook.php" class="nav-link d-flex text-white text-decoration-none fs-5 fw-semibold gap-2">
                        <i class="bi bi-bookmark"></i>
                        My Book
                    </a>
                </li>

                <li class="nav-item px-3 mt-3 text-white-50 fs-7 text-uppercase">User</li>

                <li class="nav-item">
                    <a href="user/user.php"
                        class="nav-link d-flex text-white text-decoration-none fs-5 fw-semibold gap-2">
                        <i class="bi bi-person-lines-fill"></i>
                        User
                    </a>
                </li>

                <?php if ($_SESSION['role'] === 'admin'): ?>

                    <li class="nav-item px-3 mt-3 text-white-50 fs-7 text-uppercase">Admin</li>

                    <li class="nav-item">
                        <a href="" class="nav-link d-flex text-white text-decoration-none fs-5 fw-semibold gap-2">
                            <i class="bi bi-person-lines-fill"></i>
                            Admin
                        </a>
                    </li>

                    <li class="nav-item mb-5">
                        <a href="" class="nav-link d-flex text-white text-decoration-none fs-5 fw-semibold gap-2">
                            <i class="bi bi-bookmark"></i>
                            Buku Yg Dipinjam
                        </a>
                    </li>
                <?php endif; ?>
                <form action="table/logout.php">
                    <input type="hidden" name="id">
                    <button type="submit" class="btn btn-danger btn-sm rounded" style="width: 100%; height: 40px;">
                        Log Out
                    </button>
                </form>
        </div>




        <div class="flex-fill bg-secondary p-4">
            <div class="container content-card mt-5 p-4 rounded shadow-sm text-center d-flex align-items-center justify-content-center"
                style="min-height: 130px;">
                <p class="fs-2 fw-bold m-0">Welcome Back <?= $_SESSION['user'] ?></p>
            </div>
            <div class="container content-card mt-5 p-4 rounded shadow-sm" style="min-height: 300px">

            </div>
        </div>
    </div>

</body>


</html>