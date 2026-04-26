<?php

class database
{
    private $pdo;

    function __construct()
    {
        $user = "YOUR_DB_USER";
        $password = "YOUR_DB_PASSWORD";
        $dbname = "YOUR_DB_NAME";
        $host = "YOUR_HOSTING";

        try {
            $this->pdo = new pdo("mysql:host=$host;dbname=$dbname", $user, $password);
            $this->pdo->Setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "FAILED" . $e->GetMessage();
        }
    }

    function query($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}
