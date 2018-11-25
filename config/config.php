<?php

//get database connection
$db = new Database();
$db->createConnection();

//create new shift and category objects
$shift = new Shift($db);
$category = new Category($db);