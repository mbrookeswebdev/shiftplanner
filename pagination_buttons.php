<div id="pagination">

<?php

//display page numbers:
if ($pages > 1) {
    $current_page = ($start / $display) + 1;
    if ($current_page != 1) {
        echo '<a href="index.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '&mth=' . $month . '">Previous</a> ';
    }
    for ($i = 1; $i <= $pages; $i++) {
        if ($i != $current_page) {
            echo '<a href="index.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '&mth=' . $month . '">' . $i . '</a> ';
        } else {
            echo $i . ' ';
        }
    }
//create a Next button:
    if ($current_page != $pages) {
        echo '<a href="index.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '&mth' . $month . '">Next</a>';
    }
    echo '</p>';
}
?>
</div>




