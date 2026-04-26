    <?Php 
    session_start();
    include("../connect.php");

        $files = $_FILES['folder'];
        // jika tidak menambahkan fils maka files akan default menggunkana default.jpg
        $newname = 'default.jpg';


        if(($files) && $files['error'] === 0) {
            $namefiles = $_FILES['folder']['name'];
            $tmp = $_FILES['folder']['tmp_name'];
            $folders = '../table/gambar/';
            $newname = time() . '_' . $namefiles;

            $allowedmine = ['image/jpeg', 'image/png'];

            $mime = mime_content_type($tmp);
            if(!in_array($mime, $allowedmine)) {
                $_SESSION['err'] = 'Error File Harus Berupa PNG / JPG';
                header("Location: formtambah.php");
                exit;
            }

            move_uploaded_file($tmp, $folders . $newname);
        } 


    $jb = $_POST["jb"];
    $pg = $_POST["pg"];
    $tb = $_POST["tb"];
    $stok = $_POST["stok"];

    $db = new database();
    $tahunwajar = date('Y');
    if($tb > $tahunwajar || $tb < 1200) {
        $_SESSION['err'] = "Tahun Tidak Wajar";
        header("location: formtambah.php");
        exit;
    }

        $db -> query("INSERT INTO buku (judul_buku, pengarang, tahun_terbit, stok, gambar) VALUES (?, ?, ?, ?, ?)", [ $jb, $pg, $tb, $stok, $newname ] );

    header("Location: ../table/index.php");
    ?>