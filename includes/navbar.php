<nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <a class="navbar-brand" href="index.php"><span class="align-middle"><i
                    class="material-icons">calendar_today</i></span> Shift Planner</a>
<!--hamburger navigation menu-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto">
        </ul>
<!--dropdown menu-->
        <form id="display_by_month" action="index.php" method="post">
            <ul class="navbar-nav">
                <li class="nav-item active dropdown">
                    <a class="nav-link dropdown-toggle mr-sm-2" href="#" id="navbarDropdownMenuLink"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Display shifts by month</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=01' . '">January</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=02' . '">February</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=03' . '">March</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=04' . '">April</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=05' . '">May</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=6' . '">June</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=07' . '">July</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=08' . '">August</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=09' . '">September</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=10' . '">October</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=11' . '">November</a>' ?>
                        </button>
                        <button class="dropdown-item" type="button">
                            <?php echo '<a href="index.php?mth=12' . '">December</a>' ?>
                        </button>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link mr-sm-3" href="create_shift.php">Create a new shift</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link mr-sm-3" href="logout.php">Logout</a>
                </li>
            </ul>
        </form>
    </div>
</nav>
