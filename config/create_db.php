<?php

$host = "";
$db_name = "";
$username = "";
$password = "";

try {
    $dsn = "mysql:host=$host;dbname=$db_name";
    $dbh = new PDO($dsn, $username, $password);

    $sql_create_categories_tbl =
        "CREATE TABLE categories (
        id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        entitlement INT (11) NOT NULL)";

    $sql_create_paydays_tbl =
        "CREATE TABLE paydays (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        date DATE NOT NULL,
        no_of_weeks INT(11) NOT NULL)";

    $sql_create_shifts_tbl =
        "CREATE TABLE shifts (
        id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        date DATE NOT NULL,
        start_time TIME NOT NULL,
        end_time TIME NOT NULL,
        shift_length VARCHAR(6) NOT NULL,
        rate FLOAT NOT NULL,
        pay_amount FLOAT NOT NULL,
        description VARCHAR(300),
        category VARCHAR(20) NOT NULL)";

    $sql_create_users_tbl =
        "CREATE TABLE users (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(150) NOT NULL,
        access_code VARCHAR(300) NOT NULL)";

    $statusCats = $dbh->exec($sql_create_categories_tbl);

    $statusPaydays = $dbh->exec($sql_create_paydays_tbl);

    $statusShifts = $dbh->exec($sql_create_shifts_tbl);

    $statusUsers = $dbh->exec($sql_create_users_tbl);

    // display status messages
    if ($statusCats !== false) {
        echo "Table Categories created.\r\n";
    }

    if ($statusPaydays !== false) {
        echo "Table Paydays created.\r\n";
    }

    if ($statusShifts !== false) {
        echo "Table Shifts created.\r\n";
    }

    if ($statusUsers !== false) {
        echo "Table Users created.\r\n";
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}








