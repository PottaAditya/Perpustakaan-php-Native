<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Buku</title>

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
    }

    .card {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      padding: 25px;
      width: 350px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.25);
      animation: zoomIn 0.6s ease;
    }

    @keyframes zoomIn {
      from {
        opacity: 0;
        transform: scale(0.9);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    h2 {
      text-align: center;
      color: white;
      margin-bottom: 15px;
      letter-spacing: 1px;
    }

    .field {
      margin-bottom: 18px;
      position: relative;
    }

    label {
      color: #e2e8f0;
      font-size: 14px;
      position: absolute;
      top: 10px;
      left: 12px;
      opacity: 0.7;
      transition: 0.25s;
      pointer-events: none;
    }

    input {
      width: 100%;
      padding: 12px 12px 12px 12px;
      border-radius: 8px;
      border: none;
      background: rgba(255, 255, 255, 0.22);
      color: white;
      font-size: 14px;
      outline: none;
      transition: 0.25s;
    }

    input:focus {
      background: rgba(255, 255, 255, 0.33);
      box-shadow: 0 0 8px #38bdf8;
    }

    /* Label naik */
    input:focus+label,
    input:not(:placeholder-shown)+label {
      top: -8px;
      left: 10px;
      font-size: 12px;
      opacity: 1;
      color: #7dd3fc;
    }

    button {
      width: 100%;
      padding: 11px;
      background: #0ea5e9;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 15px;
      cursor: pointer;
      overflow: hidden;
      position: relative;
      transition: 0.25s;
    }

    button:hover {
      background: #0284c7;
    }

    /* Ripple effect */
    button::after {
      content: "";
      position: absolute;
      background: rgba(255, 255, 255, 0.6);
      width: 0;
      height: 0;
      border-radius: 50%;
      transform: translate(-50%, -50%);
      opacity: 0;
      pointer-events: none;
    }

    button.ripple::after {
      animation: ripple 0.4s ease-out;
    }

    @keyframes ripple {
      from {
        width: 0;
        height: 0;
        opacity: 1;
      }

      to {
        width: 300px;
        height: 300px;
        opacity: 0;
      }
    }

    /* Shake effect */
    .shake {
      animation: shakeAnim 0.3s ease;
    }

    @keyframes shakeAnim {
      0% {
        transform: translateX(0);
      }

      25% {
        transform: translateX(-5px);
      }

      50% {
        transform: translateX(5px);
      }

      75% {
        transform: translateX(-5px);
      }

      100% {
        transform: translateX(0);
      }
    }

    input[type="file"]+label {
      top: -8px !important;
      left: 10px;
      font-size: 12px;
      opacity: 1;
      color: #7dd3fc;
    }

    .back {
      display: block;
      margin-top: 20px;
      text-decoration: none;
      color: #8f9caa;
      transition: 0.3s;
    }

    .back:hover {
      color: #ffffff;
    }
  </style>
</head>

<body>
  <form action="insertproses.php" method="POST" class="card" id="formBuku" enctype="multipart/form-data">
    <h2>Tambah Buku</h2>

    <?php if (isset($_SESSION['err'])): ?>
      <p style="color: red;"><?= $_SESSION['err']; ?></p>
      <?php
      unset($_SESSION['err']);
    endif; ?>

    <div class="field">
      <input type="text" name="jb" id="jb" placeholder=" " required />
      <label for="jb">Judul Buku</label>
    </div>

    <div class="field">
      <input type="text" name="pg" id="pg" placeholder=" " required />
      <label for="pg">Pengarang</label>
    </div>

    <div class="field">
      <input type="number" name="tb" id="tb" placeholder=" " required />
      <label for="tb">Tahun Terbit</label>
    </div>
    <div class="field">
      <input type="text" name="stok" placeholder=" ">
      <label for="stok">Stock</label>
    </div>
    <div class="field">
      <input type="file" name="folder" id="folder" />
      <label for="folder" class="file-label">Upload Gambar</label>
    </div>

    <button type="submit" id="btnSubmit">Simpan Buku</button>
    <a href="../table/index.php" class="back">← Kembali</a>
  </form>

  <script>
    const btn = document.getElementById("btnSubmit");
    const form = document.getElementById("formBuku");

    // Ripple Effect
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

    // Validasi kosong (shake)
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