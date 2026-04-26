<?Php 
session_start();
include("../connect.php");
if(!isset($_SESSION['user'])) {
        header('Location: ../user/login.php');
    }
$id = $_GET["id"];


$db = new database();
$data = $db->query("SELECT gambar FROM buku WHERE id_buku = ? ", [$id])->fetch(PDO::FETCH_ASSOC);

if($data['gambar'] != 'default.jpg') {
    unlink("../table/gambar/" . $data['gambar']);   
}

$db -> query("DELETE FROM buku WHERE id_buku = ?", [ $id ] );

header("Location: ../table/index.php");
?>