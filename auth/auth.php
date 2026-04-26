<?php
class Auth
{
    private $db;

    function __construct(database $db)
    {
        $this->db = $db;
    }

    function Demotes($id)
    {
        $this->db->query(
            "UPDATE user SET Role = 'user' WHERE id = ?",
            [$id]
        );
    }
    function promoting($id)
    {
        $this->db->query(
            "UPDATE user SET role = 'admin' WHERE id = ?",
            [$id]
        );
    }
}

class DeleteUser
{

    private $db;

    function __construct(database $db)
    {
        $this->db = $db;
    }

    function delete($id)
    {
        $this->db->query(
            "DELETE FROM user WHERE id = ?",
            [$id]
        );
    }

}

class update
{

    private $db;

    function __construct(database $db)
    {
        $this->db = $db;
    }

    function updates($username, $password, $id)
    {

        $lama = $this->db->query(
            "SELECT password FROM user WHERE id = ?",
            [$id]
        )->fetch(PDO::FETCH_ASSOC);

        if (!$lama) {
            return "Error USER_NOT_FOUND";
        }


        if (empty($password)) {

            $sama = $this->db->query(
                "SELECT id FROM user WHERE username = ? AND id != ? ",
                [$username, $id]
            )->fetch(PDO::FETCH_ASSOC);

            if ($sama) {
                return 'USERNAME_TAKEN';
            }

            $this->db->query(
                "UPDATE user SET username = ? WHERE id = ? ",
                [$username, $id]
            );

            return true;
        }





        if (password_verify($password, $lama['password'])) {
            return 'PASSWORD_SAME';
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->db->query(
            "UPDATE user SET username = ?, password = ? WHERE id = ?",
            [$username, $hash, $id]
        );

        return true;
    }

    function fpassword($username, $password, $password2)
    {


        $user = $this->db->query(
            "SELECT id FROM user WHERE username = ?",
            [$username]
        )->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return 'USERNAME_NOT_FOUND';
        }


        if ($password !== $password2) {
            return 'PASSWORD_NOT_MATCH';
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->db->query(
            "UPDATE user SET password = ? WHERE id = ?",
            [$hash, $user['id']]
        );

        return true;
    }

}
class denda
{
    private $db;

    function __construct(database $db)
    {
        $this->db = $db;
    }

    function hitungDenda($id_pinjam)
    {
        $hitung = $this->db->query("SELECT tgl_jatuh_tempo FROM peminjaman WHERE id_pinjam = ? ", [$id_pinjam])->fetch(PDO::FETCH_ASSOC);

        $tgl_tempo = $hitung['tgl_jatuh_tempo'];
        $tgl_kembali = date('Y-m-d');

        $hari_Telat = floor((strtotime($tgl_kembali) - strtotime($tgl_tempo)) / 86400);
        if ($hari_Telat < 0) {
            $hari_Telat = 0;
        }

        $perhari = 1000;

        $denda = $hari_Telat * $perhari;


        $this -> db -> query("UPDATE peminjaman SET denda = ? WHERE id_pinjam = ?" , [$denda, $id_pinjam]);

        return $denda;
    }
}
?>