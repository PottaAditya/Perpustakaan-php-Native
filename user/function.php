<?php 

class user {
    private $db;

    function __construct(database $db) {
        $this -> db = $db;
    }

    function regis($data) {
        
        $username = trim($data["username"]);
        $password = $data["password"];

            if($username === '' || $password === '') {
                return "Username Atau Password Tidak Boleh Kosong";
            }

        $stmt = $this->db->query(
        "SELECT * FROM user WHERE username = ? ", [$username]);

        if($stmt->rowCount() > 0) {
            return "Username Sudah ada";
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->query(
            "INSERT INTO user (username, password) VALUES (?, ?)", [$username, $hash]);

        return true;
    }
    function registrasi($data) {

        $username = trim($data["username"]);
        $password = $data["password"];
        $role = $data['role'];

            if($username === '' || $password === '') {
                return "Username Atau Password Tidak Boleh Kosong";
            }

        $stmt = $this->db->query(
        "SELECT * FROM user WHERE username = ? ", [$username]);

        if($stmt->rowCount() > 0) {
            return "Username Sudah ada";
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->query(
            "INSERT INTO user (username, password, role) VALUES (?, ?, ?)", [$username, $hash, $role]);

        return true;
    }

    function updateSesi()
    {
        if (!$_SESSION['user'] || !$_SESSION['role'] || !$_SESSION['user_id']) {
            return false;
        }

        $stmt = $this->db->query('SELECT * FROM user WHERE id = ?', [$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];

    }
}


?>