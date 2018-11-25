<?php

class Shift
{
//database connection and table name
    private $connection;
    private $table_name = "shifts";

//object properties
    public $id;
    public $date;
    public $start_time;
    public $end_time;
    public $shift_length;
    public $pay_amount;
    public $rate;
    public $description;
    public $category;
    public $nextPayAmount;

    public function __construct ($db)
    {
        $this->connection = $db;
    }

    function createShift ($date, $start_time, $end_time, $rate, $description, $category)
    {
        $query = "INSERT INTO " . $this->table_name . " SET 
        date=:date, start_time=:start_time, end_time=:end_time,
        shift_length=:shift_length, pay_amount=:pay_amount, rate=:rate, 
        description=:description, category=:category";

        $stmt = $this->connection->prepare($query);

//calculate shift length
        $datetime1 = new DateTime('0000-00-00 ' . $start_time);
        $datetime2 = new DateTime('0000-00-00 ' . $end_time);
        $interval = $datetime1->diff($datetime2);
        $this->shift_length = $interval->format('%H:%I');
        $this->shift_length = (float)$this->shift_length;

//calculate pay amount
        $this->pay_amount = $rate * $this->shift_length;

//bind values
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":start_time", $start_time);
        $stmt->bindParam(":end_time", $end_time);
        $stmt->bindParam(":shift_length", $this->shift_length);
        $stmt->bindParam(":pay_amount", $this->pay_amount);
        $stmt->bindParam(":rate", $rate);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":category", $category);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function displayAllShifts ($month, $order_by, $start, $display)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MONTH(date) LIKE '$month' OR MONTH(date) = '$month' ORDER BY $order_by LIMIT $start, $display";
        $stmt = $this->connection->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt;
    }

    function displayOneShift ($id)
    {
        $query = "SELECT id, date, start_time, end_time, shift_length, 
        rate, description, category FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1 ";

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $this->date = $row['date'];
        $this->start_time = $row['start_time'];
        $this->end_time = $row['end_time'];
        $this->shift_length = $row['shift_length'];
        $this->pay_amount = $row['pay_amount'];
        $this->description = $row['description'];
        $this->category = $row['category'];
        return $stmt;
    }

    function updateShift ($id, $date, $start_time, $end_time, $rate, $description, $category)
    {
        $query = "UPDATE " . $this->table_name . " SET 
        date=:date, start_time=:start_time, end_time=:end_time,
        shift_length=:shift_length, rate=:rate, pay_amount=:pay_amount, 
        description=:description, category=:category WHERE id=:id";

        $stmt = $this->connection->prepare($query);

//calculate shift length
        $datetime1 = new DateTime('0000-00-00 ' . $start_time);
        $datetime2 = new DateTime('0000-00-00 ' . $end_time);
        $interval = $datetime1->diff($datetime2);
        $this->shift_length = $interval->format('%H:%I');
        $this->shift_length = (float)$this->shift_length;

//calculate pay amount
        $this->pay_amount = $rate * $this->shift_length;

// bind values
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":start_time", $start_time);
        $stmt->bindParam(":end_time", $end_time);
        $stmt->bindParam(":shift_length", $this->shift_length);
        $stmt->bindParam(":pay_amount", $this->pay_amount);
        $stmt->bindParam(":rate", $rate);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":category", $category);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function deleteShift ($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ? ";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

//check the database for double entries
    function duplicateEntryCheck ($date)
    {
        $query = "SELECT * from " . $this->table_name . " WHERE date=:date";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":date", $date);
        $stmt->execute();
        $duplicateEntry = $stmt->rowCount();

        if ($duplicateEntry > 0) {
            return true;
        } else {
            return false;
        }
    }

    function countShifts ()
    {
        $query = "SELECT COUNT(*) count FROM " . $this->table_name . "";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['count'];
    }

    function countShiftsInASpecificMonth ($month)
    {
        $query = "SELECT COUNT(*) count FROM " . $this->table_name . " WHERE MONTH(date) = '$month'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['count'];
    }

    function calculateNextPayAmount ()
    {
        $query = "SELECT date, pay_amount as total FROM " . $this->table_name . " WHERE date >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY) 
                  AND date <= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 MONTH)), INTERVAL 0 DAY) and category = 'work'";

        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->nextPayAmount = $row['total'];
        return $this->nextPayAmount;
    }

    function showNoOfHolidaysBooked ()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE category = 'holiday'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $numberOfRows = $stmt->rowCount();
        return $numberOfRows;
    }
}
