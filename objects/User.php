<?php

class User
{
//database connection and table name
    private $connection;
    private $table_name = "users";

//object properties
    private $id;
    private $name;
    private $access_code;

    public function __construct ($db)
    {
        $this->connection = $db;
    }

//check details provided by a user to grant access to protected pages
    function checkNameAndAccessCode ($providedName, $providedAccessCode)
    {
        $query = "SELECT * from " . $this->table_name .
            " WHERE name=:name and access_code=:accessCode";

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":name", $providedName);
        $stmt->bindParam(":accessCode", $providedAccessCode);
        $stmt->execute();
        $userExists = $stmt->rowcount();
        return $userExists;
    }
}