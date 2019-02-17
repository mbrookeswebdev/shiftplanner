<?php

class Database
{
    //variables necessary for setting up a database connection
    private $host = "";
    private $db_name = "";
    private $username = "";
    private $password = "";
    public $connection;

    //function to create a new db connection
    function createConnection ()
    {
        $this->connection = null;
        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Sorry, a connection to the database could not be established. " . $exception->getMessage();
        }
        return $this->connection;
    }

    function prepare ($item)
    {
        return $this->connection->prepare($item);
    }
}
