<?php

include_once 'config/Database.php';
include_once 'objects/User.php';
include_once 'includes/header.php';
include_once 'validation.php';

session_start();

//if the user provided login details
if (isset($_POST['name']) && isset($_POST['access_code'])) {

//validate details
    $userName = validate($_POST['name']);
    $userAccessCode = validate($_POST['access_code']);

//get database connection
    $db = new Database();
    $db->createConnection();

//check if user has a right to login
    $user = new User($db);
    $result = $user->checkNameAndAccessCode($userName, $userAccessCode);

//if the user is registered, set session variables for access to data
    if ($result) {
        $_SESSION['name'] = $userName;
        $_SESSION['access_code'] = $userAccessCode;
//redirect to the protected page or display an error message
        header('Location: index.php');
    } else {
        echo "<div class='alert alert-danger text-center justify-content-center' id='error-msg'>Sorry, your details are incorrect. Please try again or contact the administrator.</div>";
    }
}
?>

<div class="container" id="main">
<!-- display the login form-->
    <div class="container" id="loginscreen">
    <div class="row justify-content-md-center">
        <div class="col col-md-3">
        </div>
        <div id="logindets" class="col-md-6">
        <div class="row justify-content-center" id="app_name"><h3>Shift Planner</h3></div>
        <div class="row justify-content-center"><i class="material-icons md-48 light-blue" id="logo">person</i></div>
        <div class="row justify-content-center" id="instruction"><h5>Please login:</h5></div>
        <form id="login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <div class="row justify-content-center">
                    <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php if
                    (isset($_POST['name'])) echo $_POST['name']; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="row justify-content-center">
                    <input type="password" id="access_code" name="access_code" placeholder="Enter your access code"
                           value="<?php if
                           (isset($_POST['access_code'])) echo $_POST['access_code']; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="row justify-content-center">
                    <input id="submit" type="submit" class="btn btn-info" value="Submit">
                </div>
            </div>
        </form>
        </div>
            <div class="col col-md-3">
            </div>
    </div>
</div>
</div>
<?php include_once 'includes/footer.php'; ?>







