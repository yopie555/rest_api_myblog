<?php
class Database
{
    //DB Params
    private $host = 'localhost';
    private $db_name = 'myblog';
    private $username = 'root';
    private $password = '';
    private $conn; //Connection

    //DB Connect
    public function connect()
    {
        $this->conn = null; //Reset connection
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';
            dbname=' . $this->db_name,
                $this->username,
                $this->password
            ); //Create connection
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE, //set Attribute
                PDO::ERRMODE_EXCEPTION //set error mode
            );
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage(); //Output error message
        }
        return $this->conn; //Return connection
    }
}
