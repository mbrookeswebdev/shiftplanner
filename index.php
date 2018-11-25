<?php

session_start();

//set the name variable to greet user
if (isset($_SESSION['access_code']) && (isset($_SESSION['name']))) {
    $name = $_SESSION['name'];

// include the database and object files
    include_once 'config/Database.php';
    include_once 'objects/Shift.php';
    include_once 'objects/Category.php';
    include_once 'objects/Payday.php';
    include_once 'includes/header.php';
    include_once 'config/config.php';

    if (isset($_GET['mth']) && is_numeric($_GET['mth'])) {
        $month = $_GET['mth'];
    } else {
        $month = '%';
    }

    include_once 'config/pagination_params.php';

//get shift records from displayAll method
    $stmt = $shift->displayAllShifts($month, $order_by, $start, $display);

//count total rows
    $numberOfShifts = $shift->countShifts();

    include_once('includes/navbar.php');

    echo '<div class="container" id="main">';

//return and process data for user statistics
    $now = strtotime(date("d-m-y"));
    $payday = new payday($db);
    $payday->displayNextPayDate();
    $noWeeks = $payday->getNextNoOfWeeksPay();
    $paydate = $payday->formatDate();

    $daysLeft = 0;
    $fromDate = $paydate;
    $curDate = date('d-m-Y');
    $daysLeft = abs(strtotime($curDate) - strtotime($fromDate)); //convert dates into UNIX format
    $days = $daysLeft / 86400; //difference in seconds (or 60*60*24)
    $sum = $shift->calculateNextPayAmount();
    $number = $shift->showNoOfHolidaysBooked();
    $entitledTo = $category->getNoOfHolidays();
    $numberLeft = $entitledTo - $number;

    ?>

    <div id="delete_status">
        <?php
        if (isset($_GET['delete_status']) && $_GET['delete_status'] == 1) {
            echo "<div class='alert alert-success text-center' id='success-msg'>Success, your shift was deleted.</div>";
        } else {
            if (isset($_GET['delete_status']) && $_GET['delete_status'] == 0) {
                echo "<div class='alert alert-danger text-center' id='error-msg'>Sorry, the shift couldnt be deleted.</div>";
            }
        }
        ?>
    </div>

    <div id="update_status">
        <?php
        if (isset($_GET['update_status']) && $_GET['update_status'] == 1) {
            echo "<div class='alert alert-success text-center' id='success-msg'>Success, your shift was updated.</div>";
        } else {
            if (isset($_GET['update_status']) && $_GET['update_status'] == 0) {
                echo "<div class='alert alert-danger text-center' id='error-msg'>Sorry, the shift couldnt be updated.</div>";
            }
        }
        ?>
    </div>

<!--display user statistics-->
    <div class="container" id="statistics">
        <div class="row justify-content-md-left">
            <div class="col col-md-6">
                <p><?php echo '<h5>Hello, ' . ucfirst($name) . '!';
                    '</h5>'; ?></p>
                <p><?php echo '<h6>Today is ' . date("l") . ", " . date("d-m-Y") . '.';
                '</h6>' ?><p></p>
                <p><?php echo '<h6>Next payday is on ' . $paydate . ' - ' . $days . ' days to go.';
                    '</h6>' ?></p>
                <p><?php echo '<h6>You will be paid for ' . $noWeeks . ' weeks - £' . number_format($sum, 2) . ' (net).';
                    '</h6>' ?></p>
                <p><?php echo '<h6>You\'ve booked ' . $number . ' day(s) holiday this year - ' . $numberLeft . '  days remaining.';
                    '</h6>' ?></p>
            </div>
        </div>
        <div class="col-md-3">
        </div>
        <div class="col col-md-3">
        </div>
    </div>

    <?php
//if there are shifts to display:
    if ($stmt->rowCount() > 0) { ?>
        <!--// display results in a table: -->
        <table class="table table-sm table-striped text-center table-responsive" id="display_all">
            <thead>
            <tr>
                <th scope="col" style="width: 1%"></th>
                <th scope="col" style="width: 5%">Cat</th>
                <th scope="col" style="width: 12%">
                    <?php echo '<a href="index.php?s=' . $start . '&p=' . $pages . '&sort=date' . '&mth=' . $month . '">Date</a>' ?>
                </th>
                <th class="d-none d-sm-table-cell" scope="col" style="width: 9%">Start</th>
                <th class="d-none d-sm-table-cell" scope="col" style="width: 9%">Finish</th>
                <th class="d-none d-sm-table-cell" scope="col" style="width: 10%">Hrs</th>
                <th class="d-none d-sm-table-cell" scope="col" style="width: 8%">
                    <?php echo '<a href="index.php?s=' . $start . '&p=' . $pages . '&sort=rate' . '&mth=' . $month . '">Rate</a>' ?>
                </th>
                <th scope="col" style="width: 14%">Pay (net)</th>
                <th class="d-none d-sm-table-cell" scope="col" style="width: 8%">Type</th>
                <th class="d-none d-sm-table-cell" scope="col" style="width: 15%">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($row['id']) ?>"</td>
                    <td>
                        <?php if ($row['category'] == 'work') { ?><i class="material-icons">work</i>
                        <?php }
                        if ($row['category'] == 'holiday') { ?><i class="material-icons">wb_sunny</i>
                        <?php }
                        if ($row['category'] == 'off sick') { ?><i class="material-icons">local_hospital</i>
                        <?php }
                        if ($row['category'] == 'day off') { ?> <i class="material-icons">work_off</i>
                        <?php }
                        if ($row['category'] == 'unavailable') { ?> <i class="material-icons">highlight_off</i>
                        <?php }
                        ?>
                    </td>
                    <td style="font-weight:normal"><?php echo htmlspecialchars(date('d-m-y', strtotime($row['date']))); ?></td>
                    <td class="d-none d-sm-table-cell"
                        style="font-weight:normal"><?php echo substr(htmlspecialchars($row['start_time']), 0, 5) ?></td>
                    <td class="d-none d-sm-table-cell"
                        style="font-weight:normal"><?php echo substr(htmlspecialchars($row['end_time']), 0, 5) ?></td>
                    <td class="d-none d-sm-table-cell"
                        style="font-weight:normal"><?php echo htmlspecialchars($row['shift_length']); ?></td>
                    <td class="d-none d-sm-table-cell"
                        style="font-weight:normal"><?php echo number_format(htmlspecialchars($row['rate']), 2); ?></td>
                    <td style="font-weight:normal"><?php echo '£' . number_format(htmlspecialchars($row['pay_amount']), 2); ?></td>
                    <th class="d-none d-sm-table-cell"
                        style="font-weight:normal"><?php echo htmlspecialchars($row['description']); ?></th>
                    <td class="d-none d-sm-table-cell"><a
                                href="update_shift.php?id=<?php echo htmlspecialchars($row['id']) ?>">
                            <button type="button" class="btn btn-warning">Edit</button>
                        </a>
                        <a href="delete_shift.php?id=<?php echo htmlspecialchars($row['id']) ?>">
                            <button type="button" class="btn btn-danger">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>


<!--if there are no results to display in a table, display an info message-->
        <?php
    } else {
        echo "<div class='alert alert-info' role='alert'>Sorry, there are no records for the requested month.</div>";
    }

    include_once('pagination_buttons.php'); ?>

    <div class="container" id="legend">
        <div class="row justify-content-md-left">
            <div class="col col-md-6">
                <h6>Legend:</h6>
                <div id="l1"><img src="resources/images/baseline-work-24px.svg" alt="Work" height="15px" width="15px"> - Work
                    <img src="resources/images/baseline-work_off-24px.svg" height="15px" width="15px" alt="Off"> - Day off
                    <img src="resources/images/baseline-local_hospital-24px.svg" height="15px" width="15px" alt="Off sick"> -
                    Off sick</l1>
                    <div id="l2">
                        <img src="resources/images/baseline-wb_sunny-24px.svg" height="15px" width="15px" alt="Holiday"> -
                        Holiday
                        <img src="resources/images/outline-highlight_off-24px.svg" height="15px" width="15px" alt="Unavailable">
                        -
                        Unavailable
                    </div>
                </div>
            </div>
            <div class="col-md-3">
            </div>
            <div class="col col-md-3">
            </div>
        </div>

    <?php

//close main div
    echo '</div>';

    include_once "includes/footer.php";

//if the user is not logged in, redirect to login page
} else {
    header("Location: login.php");
    exit;
}
?>