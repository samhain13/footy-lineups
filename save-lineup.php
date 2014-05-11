<?php

require_once "settings.php";

if (isset($_POST["lineup"])) {
    $fn = md5($_POST["lineup"]);
    $handle = fopen("lineups/" . $fn . ".txt", "w");
    fwrite($handle, $_POST["lineup"]);
    fclose();
    $loc = "?lineup=" . $fn;
} else {
    $loc = "error.html";
}

header("Location: " . SITE_DOMAIN . $loc);

?>
