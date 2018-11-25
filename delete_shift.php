<?php

// include the database and object files
include_once 'config/Database.php';
include_once 'objects/Shift.php';
include_once 'objects/Category.php';
include_once 'validation.php';
include_once 'config/config.php';

//check if the ID was passed on
$id = validate(isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.'));

//display details of the shift to be deleted
$stmt = $shift->displayOneShift($id);

// if the form was submitted, can update the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//delete shift, redirect to the main page and display an info message
    if ($shift->deleteShift($id)) {
        header("Location: index.php?delete_status=1");
        exit;
    } else {
        header("Location: index.php?delete_status=0");
        exit;
    }
}

include_once "includes/header.php";
include_once "includes/navbar.php";

echo '<div class="container" id="main">';

//display the details of the shift in a form
if ($stmt) {
    while ($row = $stmt->fetch()): ?>

        <div class="container" id="delete_form">
        <div class="row justify-content-md-center">
        <div class="col col-md-3">
        </div>
        <div class="col-md-6">
        <div class="row justify-content-center" id="instruction3">Please check the details below:</div>
        <form id="delete_shift" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id={$id}"; ?>" method="post">
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="id">ID:</label>
                <input type="text" class="form-control" name="id"
                       value="<?php echo htmlspecialchars($row['id']) ?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="date"> Date:</label>
                <input type="date" class="form-control" id="date" name="date"
                       value="<?php echo htmlspecialchars($row['date']) ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="category"> Current category:</label>
                <input type="text" class="form-control" id="category" name="category" size="6"
                       value="<?php echo htmlspecialchars($row['category']); ?>"
                >
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="start_time"> Start time:</label>
                <input type="text" class="form-control" id="start_time" name="start_time" size="5"
                       value="<?php echo substr(htmlspecialchars($row['start_time']), 0, 5) ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="end_time"> End time:</label>
                <input type="text" class="form-control" id="end_time" name="end_time" size="5"
                       value="<?php echo substr(htmlspecialchars($row['end_time']), 0, 5) ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="rate"> Rate: </label>
                <input type="text" class="form-control" id="rate" name="rate" size="6"
                       value="<?php echo htmlspecialchars($row['rate']); ?>"
                >
            </div>
        </div>
        <div class="form-group">
            <div class="row justify-content-center">
                <label for="descr"> Shift type:</label>
                <input type="text" class="form-control" id="description" name="description"
                       value="<?php echo htmlspecialchars($row['description']); ?>"
                >
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="button">
                <button id="submit" type="submit" class="btn btn-danger">Delete shift</button>
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

include_once "includes/footer.php"; ?>