<?php

class Payday
{
//database connection and table name
    private $connection;
    private $table_name = "paydays";

//object properties
    private $id;
    private $date;
    private $no_of_weeks;

    public function __construct ($db)
    {
        $this->connection = $db;
    }

//display the next pay date
    function displayNextPayDate ()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE date = (SELECT min(date) FROM " . $this->table_name . " WHERE date > curdate())";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->date = $row['date'];
        $this->no_of_weeks = $row['no_of_weeks'];
    }

    function formatDate ()
    {
        $date = date_create($this->date);
        $date = date_format($date, 'd-m-Y');
        return $date;
    }

//display how many weeks the user will be paid for on the next payday
    function getNextNoOfWeeksPay ()
    {
        $query = "SELECT no_of_weeks FROM " . $this->table_name . " WHERE date = (SELECT min(date) FROM " . $this->table_name . " WHERE date > curdate())";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->no_of_weeks = $row['no_of_weeks'];
        return $this->no_of_weeks;
    }
}
