<?php

//set no of records to show per page:
$display = 10;

//determine how many pages there are:
if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    $pages = $_GET['p'];
} else {

    include_once 'config/config.php';

    if ($month != '%') {
        $records = $shift->countShiftsInASpecificMonth($month);
    } else {
        $records = $shift->countShifts();
    }

//if there are more results than would fit on one page,
// calculate the no of pages needed to display all records:
    if ($records > $display) {
        $pages = ceil($records / $display);
    } else {
        $pages = 1;
    }
}
//determine the point where from in db to return results:
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
    $start = $_GET['s'];
} else {
    $start = 0;
}

//default sort is by shift date:
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'date';

//determine the sorting order:
switch ($sort) {
    case 'date':
        $order_by = 'date ASC';
        break;
    case 'rate':
        $order_by = 'rate ASC';
        break;
    default:
        $order_by = 'date ASC';
        $sort = 'date';
        break;
}

