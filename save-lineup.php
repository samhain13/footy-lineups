<?php

require_once "settings.php";

if (isset($_POST["lineup"])) {
    $fn = md5($_POST["lineup"]);
    $handle = fopen("lineups/" . $fn . ".txt", "w");
    fwrite($handle, $_POST["lineup"]);
    fclose();
    header("Location: " . SHOW_LINEUP_URI . $fn);
} else {
    header("Location: " . ERROR_PAGE);
}

?>
