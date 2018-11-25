<?php

// include database and object files
include_once 'config/Database.php';
include_once 'objects/Shift.php';
include_once 'objects/Category.php';
include_once "includes/header.php";
include_once "includes/navbar.php";
include_once 'validation.php';
include_once 'config/config.php';

echo '<div class="container" id="main">';

$result = null;

//if the request to create a new shift was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//if the form has been filled in fully
    if (isset($_POST['date']) && ($_POST['start_time']) && ($_POST['end_time']) && ($_POST['rate']) && ($_POST['description']) && ($_POST['category'])) {
//validate entered data
        $date = validate($_POST['date']);
        $start_time = validate($_POST['start_time']);
        $end_time = validate($_POST['end_time']);
        $rate = validate($_POST['rate']);
        $description = validate($_POST['description']);
        $category = validate($_POST['category']);

//check for a duplicate entry in a database
        $duplicateEntry = $shift->duplicateEntryCheck($date);

//if there isn't a shift on a given date in a database already, create a new shift
        if (!$duplicateEntry) {
            $result = $shift->createShift($date, $start_time, $end_time, $rate, $description, $category);
//clear the variable
            unset($duplicateEntry);
        } else {
//if there is a shift already, display an info message
            echo "<div class='alert alert-danger text-center' id='error-msg1'>There is already a shift on this date in a database. Please check and update the hours if required.</div>";
        }

//if the shift was created, display a success message, if not display an error message
        if ($result == true) {
//clear the form
            $_POST = array();
            echo "<div class='alert alert-success text-center' id='success-msg1'>Thank you. The shift was created.</div>";
        } else {
            echo "<div class='alert alert-danger text-center' id='error-msg2'>Sorry, the shift couldn't be created.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center' id='error-msg3'>Please complete all fields of the form.</div>";
    }
}
?>

<!--the form with new shift details-->
<div class="container" id="create_form">
    <div class="row justify-content-md-center">
        <div class="col col-md-3">
        </div>
        <div class="col-md-6">
        <div class="row justify-content-center" id="instruction3">Please enter your shift details:</div>
        <form id="create_shift" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
              enctype="multipart/form-data">
            <div class="form-group">
                <div class="row justify-content-center">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?php if
                    (isset($_POST['date'])) echo $_POST['date']; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="row justify-content-center">
                    <label for="category">Category:</label>
                    <select class="form-control" id="category" name="category">
                        <option value="" selected>please select:</option>
                        <option <?php if (!empty($_POST['category']) && ($_POST['category']) == "work") {
                            echo 'selected="selected"';
                        } ?> value="work">work
                        </option>
                        <option <?php if (!empty($_POST['category']) && ($_POST['category']) == "day off") {
                            echo 'selected="selected"';
                        } ?> value="day off">day off
                        </option>
                        <option <?php if (!empty($_POST['category']) && ($_POST['category']) == "holiday") {
                            echo 'selected="selected"';
                        } ?>value="holiday">holiday
                        </option>
                        <option <?php if (!empty($_POST['category']) && ($_POST['category']) == "off sick") {
                            echo 'selected="selected"';
                        } ?> value="off sick">off sick
                        </option>
                        <option <?php if (!empty($_POST['category']) && ($_POST['category']) == "unavailable") {
                            echo 'selected="selected"';
                        } ?> value="unavailable">unavailable
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="row justify-content-center">
                    <label for="start_time">Start time:</label>
                    <select class="form-control" id="start_time" name="start_time">
                        <option value="" selected>please select:</option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "08:00") {
                            echo 'selected="selected"';
                        } ?> value="08:00">08:00
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "08:30") {
                            echo 'selected="selected"';
                        } ?> value="08:30">08:30
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "09:00") {
                            echo 'selected="selected"';
                        } ?>value="09:00">09:00
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "09:30") {
                            echo 'selected="selected"';
                        } ?> value="09:30">09:30
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "10:00") {
                            echo 'selected="selected"';
                        } ?> value="10:00">10:00
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "10:30") {
                            echo 'selected="selected"';
                        } ?> value="10:30">10:30
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "11:00") {
                            echo 'selected="selected"';
                        } ?>value="11:00">11:00
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "11:30") {
                            echo 'selected="selected"';
                        } ?> value="11:30">11:30
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "12:00") {
                            echo 'selected="selected"';
                        } ?> value="12:00">12:00
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "12:30") {
                            echo 'selected="selected"';
                        } ?> value="12:30">12:30
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "15:00") {
                            echo 'selected="selected"';
                        } ?>value="15:00">15:00
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "16:00") {
                            echo 'selected="selected"';
                        } ?> value="16:00">16:00
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "16:30") {
                            echo 'selected="selected"';
                        } ?> value="16:30">16:30
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "17:00") {
                            echo 'selected="selected"';
                        } ?> value="17:00">17:00
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "17:30") {
                            echo 'selected="selected"';
                        } ?> value="17:30">17:30
                        </option>
                        <option <?php if (!empty($_POST['start_time']) && ($_POST['start_time']) == "18:00") {
                            echo 'selected="selected"';
                        } ?> value="18:00">18:00
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="row justify-content-center">
                    <label for="end_time">End time:</label>
                    <select class="form-control" id="end_time" name="end_time">
                        <option value="">please select:</option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "16:00") {
                            echo 'selected="selected"';
                        } ?> value="16:00">16:00
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "16:30") {
                            echo 'selected="selected"';
                        } ?> value="16:30">16:30
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "17:00") {
                            echo 'selected="selected"';
                        } ?>value="17:00">17:00
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "17:30") {
                            echo 'selected="selected"';
                        } ?> value="17:30">17:30
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "18:00") {
                            echo 'selected="selected"';
                        } ?> value="18:00">18:00
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "18:30") {
                            echo 'selected="selected"';
                        } ?> value="18:30">18:30
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "19:00") {
                            echo 'selected="selected"';
                        } ?>value="19:00">19:00
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "19:30") {
                            echo 'selected="selected"';
                        } ?> value="19:30">19:30
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "20:00") {
                            echo 'selected="selected"';
                        } ?> value="20:00">20:00
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "20:30") {
                            echo 'selected="selected"';
                        } ?> value="20:30">20:30
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "21:00") {
                            echo 'selected="selected"';
                        } ?>value="21:00">21:00
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "21:30") {
                            echo 'selected="selected"';
                        } ?> value="21:30">21:30
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "22:00") {
                            echo 'selected="selected"';
                        } ?> value="22:00">22:00
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "22:30") {
                            echo 'selected="selected"';
                        } ?> value="22:30">22:30
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "23:00") {
                            echo 'selected="selected"';
                        } ?>value="23:00">23:00
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "23:30") {
                            echo 'selected="selected"';
                        } ?> value="23:30">23:30
                        </option>
                        <option <?php if (!empty($_POST['end_time']) && ($_POST['end_time']) == "00:00") {
                            echo 'selected="selected"';
                        } ?> value="00:00">00:00
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="row justify-content-center">
                    <label for="rate">Rate:</label>
                    <select class="form-control" id="rate" name="rate">
                        <option value="" selected>please select:</option>
                        <option <?php if (!empty($_POST['rate']) && ($_POST['rate']) == "7.50") {
                            echo 'selected="selected"';
                        } ?> value="7.50">7.50
                        </option>
                        <option <?php if (!empty($_POST['rate']) && ($_POST['rate']) == "7.90") {
                            echo 'selected="selected"';
                        } ?> value="7.90">7.90
                        </option>
                        <option <?php if (!empty($_POST['rate']) && ($_POST['rate']) == "8.20") {
                            echo 'selected="selected"';
                        } ?>value="8.20">8.20
                        </option>
                        <option <?php if (!empty($_POST['rate']) && ($_POST['rate']) == "8.90") {
                            echo 'selected="selected"';
                        } ?> value="8.90">8.90
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="row justify-content-center">
                    <label for="description">Shift type:</label>
                    <select class="form-control" id="description" name="description">
                        <option value="" selected>please select:</option>
                        <option <?php if (!empty($_POST['description']) && ($_POST['description']) == "retail") {
                            echo 'selected="selected"';
                        } ?> value="retail">retail
                        </option>
                        <option <?php if (!empty($_POST['description']) && ($_POST['description']) == "ushering") {
                            echo 'selected="selected"';
                        } ?> value="ushering">ushering
                        </option>
                        <option <?php if (!empty($_POST['description']) && ($_POST['description']) == "pizza point") {
                            echo 'selected="selected"';
                        } ?>value="pizza point">pizza point
                        </option>
                        <option <?php if (!empty($_POST['description']) && ($_POST['description']) == "coffee") {
                            echo 'selected="selected"';
                        } ?> value="coffee">coffee
                        </option>
                    </select>
                </div>
            </div>
            <div class="button row justify-content-center">
                <button id="submit" type="submit" class="btn btn-info">Save shift</button>
            </div>
        </form>
        </div>
        <div class="col col-md-3">
        </div>
    </div>
</div>
<?php echo '</div>';

include_once "includes/footer.php"; ?>

