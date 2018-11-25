<?php

//include the database and object files
include_once 'config/Database.php';
include_once 'objects/Shift.php';
include_once 'objects/Category.php';
include_once 'validation.php';
include_once 'config/config.php';

$result = 0;

//check if the ID was passed on
$id = validate(isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.'));

//display the details of the shift to be updated
$stmt = $shift->displayOneShift($id);

//if the request to update a shift was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //if form has been filled in fully
    if (isset($_POST['date']) && ($_POST['start_time']) && ($_POST['end_time']) && ($_POST['rate']) && ($_POST['description']) && ($_POST['category'])) {
        //set new shift property values
        $date = validate($_POST['date']);
        $start_time = validate($_POST['start_time']);
        $end_time = validate($_POST['end_time']);
        $rate = validate($_POST['rate']);
        $description = validate($_POST['description']);
        $category = validate($_POST['category']);

        $result = $shift->updateShift($id, $date, $start_time, $end_time, $rate, $description, $category);

        if ($result == true) {
            header("Location: index.php?update_status=1");
            exit;
        } else {
            header("Location: index.php?update_status=0");
            exit;
        }
    } else {
        include_once "includes/header.php";
        include_once "includes/navbar.php";
        echo '<div class="container" id="main">';
        echo "<div class='alert alert-danger text-center' id='error-msg4'>Please complete all fields of the form.</div>";
    }
}

include_once "includes/header.php";
include_once "includes/navbar.php";

echo '<div class="container" id="main">';

//display the details of the shift in a form
if ($stmt) {
    while ($row = $stmt->fetch()): ?>

        <div class="container" id="update_form">
        <div class="row justify-content-md-center">
        <div class="col col-md-3">
        </div>
        <div class="col-md-6">
<!--//update shift form:-->
        <div class="row justify-content-center" id="instruction3">Please update your shift details:</div>
        <form id="update_shift" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id={$id}"; ?>" method="post">
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="id" class="">ID:</label>
                <input type="id" class="form-control" name="id"
                       value="<?php echo htmlspecialchars($row['id']) ?>" disabled required>
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="date" class=""> Date:</label>
                <input type="date" class="form-control" id="date" name="date"
                       value="<?php echo htmlspecialchars($row['date']) ?>" required>
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="category" class=""> Category:</label>
                <select class="form-control" id="category" name="category">
                    <option value="" selected>please select:</option>
                    <option <?php if ((htmlspecialchars($row['category']) == "work")) {
                        echo 'selected="selected"';
                    } ?> value="work">work
                    </option>
                    <option <?php if ((htmlspecialchars($row['category']) == "day off")) {
                        echo 'selected="selected"';
                    } ?> value="day off">day off
                    </option>
                    <option <?php if ((htmlspecialchars($row['category']) == "holiday")) {
                        echo 'selected="selected"';
                    } ?>value="holiday">holiday
                    </option>
                    <option <?php if ((htmlspecialchars($row['category']) == "off sick")) {
                        echo 'selected="selected"';
                    } ?> value="off sick">off sick
                    </option>
                    <option <?php if ((htmlspecialchars($row['category']) == "unavailable")) {
                        echo 'selected="selected"';
                    } ?> value="unavailable">unavailable
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="start_time" class=""> Start time:</label>
                <select class="form-control" id="start_time" name="start_time">
                    <option value="" selected>please select:</option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "08:00") {
                        echo 'selected="selected"';
                    } ?> value="08:00">08:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "08:30") {
                        echo 'selected="selected"';
                    } ?> value="08:30">08:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "09:00") {
                        echo 'selected="selected"';
                    } ?>value="09:00">09:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "09:30") {
                        echo 'selected="selected"';
                    } ?> value="09:30">09:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "10:00") {
                        echo 'selected="selected"';
                    } ?> value="10:00">10:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "10:30") {
                        echo 'selected="selected"';
                    } ?> value="10:30">10:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "11:00") {
                        echo 'selected="selected"';
                    } ?>value="11:00">11:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "11:30") {
                        echo 'selected="selected"';
                    } ?> value="11:30">11:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "12:00") {
                        echo 'selected="selected"';
                    } ?> value="12:00">12:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "12:30") {
                        echo 'selected="selected"';
                    } ?> value="12:30">12:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "15:00") {
                        echo 'selected="selected"';
                    } ?>value="15:00">15:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "16:00") {
                        echo 'selected="selected"';
                    } ?> value="16:00">16:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "16:30") {
                        echo 'selected="selected"';
                    } ?> value="16:30">16:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "17:00") {
                        echo 'selected="selected"';
                    } ?> value="17:00">17:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "17:30") {
                        echo 'selected="selected"';
                    } ?> value="17:30">17:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['start_time']), 0, 5) == "18:00") {
                        echo 'selected="selected"';
                    } ?> value="18:00">18:00
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="end_time" class=""> End time:</label>
                <select class="form-control" id="end_time" name="end_time">
                    <option value="">please select:</option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "16:00") {
                        echo 'selected="selected"';
                    } ?> value="16:00">16:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "16:30") {
                        echo 'selected="selected"';
                    } ?> value="16:30">16:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "17:00") {
                        echo 'selected="selected"';
                    } ?>value="17:00">17:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "17:30") {
                        echo 'selected="selected"';
                    } ?> value="17:30">17:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "18:00") {
                        echo 'selected="selected"';
                    } ?> value="18:00">18:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "18:30") {
                        echo 'selected="selected"';
                    } ?> value="18:30">18:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "19:00") {
                        echo 'selected="selected"';
                    } ?>value="19:00">19:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "19:30") {
                        echo 'selected="selected"';
                    } ?> value="19:30">19:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "20:00") {
                        echo 'selected="selected"';
                    } ?> value="20:00">20:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "20:30") {
                        echo 'selected="selected"';
                    } ?> value="20:30">20:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "21:00") {
                        echo 'selected="selected"';
                    } ?>value="21:00">21:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "21:30") {
                        echo 'selected="selected"';
                    } ?> value="21:30">21:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "22:00") {
                        echo 'selected="selected"';
                    } ?> value="22:00">22:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "22:30") {
                        echo 'selected="selected"';
                    } ?> value="22:30">22:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "23:00") {
                        echo 'selected="selected"';
                    } ?>value="23:00">23:00
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "23:30") {
                        echo 'selected="selected"';
                    } ?> value="23:30">23:30
                    </option>
                    <option <?php if (substr(htmlspecialchars($row['end_time']), 0, 5) == "00:00") {
                        echo 'selected="selected"';
                    } ?> value="00:00">00:00
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="rate" class=""> Rate: </label>
                <select class="form-control" id="rate" name="rate">
                    <option value="" selected>please select:</option>
                    <option <?php if ((htmlspecialchars($row['rate']) == "7.50")) {
                        echo 'selected="selected"';
                    } ?> value="7.50">7.50
                    </option>
                    <option <?php if ((htmlspecialchars($row['rate']) == "7.90")) {
                        echo 'selected="selected"';
                    } ?> value="7.90">7.90
                    </option>
                    <option <?php if ((htmlspecialchars($row['rate']) == "8.20")) {
                        echo 'selected="selected"';
                    } ?>value="8.20">8.20
                    </option>
                    <option <?php if ((htmlspecialchars($row['rate']) == "8.90")) {
                        echo 'selected="selected"';
                    } ?> value="8.90">8.90
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="descr" class=""> Shift type:</label>
                <select class="form-control" id="description" name="description">
                    <option value="" selected>please select:</option>
                    <option <?php if (htmlspecialchars($row['description']) == "retail") {
                        echo 'selected="selected"';
                    } ?> value="retail">retail
                    </option>
                    <option <?php if (!htmlspecialchars($row['description']) == "ushering") {
                        echo 'selected="selected"';
                    } ?> value="ushering">ushering
                    </option>
                    <option <?php if (htmlspecialchars($row['description']) == "pizza point") {
                        echo 'selected="selected"';
                    } ?>value="pizza point">pizza point
                    </option>
                    <option <?php if (htmlspecialchars($row['description']) == "coffee") {
                        echo 'selected="selected"';
                    } ?> value="coffee">coffee
                    </option>
                </select>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="button">
                <button id="submit" type="submit" class="btn btn-info">Save</button>
            </div>
        </div>
    <?php endwhile; ?>
    </form>
<?php } ?>
    </div>
    <div class="col col-md-3">
    </div>
    </div>
    </div>

<?php echo '</div>';

include_once "includes/footer.php";