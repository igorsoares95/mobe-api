<?php
class Conexao_BD {
    private $conn;
 
    // Connecting to database
    public function conexao() {
        require_once 'include/Config.php';
         
        // Connecting to mysql database
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
         
        // return database handler
        return $this->conn;
    }
}
 
?>