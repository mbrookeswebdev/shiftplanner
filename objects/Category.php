<?php

class Category
{
//database connection and table name
    private $connection;
    private $table_name = "categories";

//object properties
    private $id;
    private $name;
    private $holiday_entitlement;

    public function __construct ($db)
    {
        $this->connection = $db;
    }

//read category name by its ID
    function readCategoryName ()
    {
        $query = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
    }

//display no of holidays the user is entitled to
    function getNoOfHolidays ()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE name = 'holiday'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->holiday_entitlement = $row['entitlement'];
        return $this->holiday_entitlement;
    }
}

