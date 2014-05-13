<?php

// Because we don't like hardcoding stuff like this in our scripts.

// SITE_DOMAIN value must be http:/<domain-name-or-ip>[:port][/path-to-here]/
// Must be changed per instance. Don't forget the trailing slash.
define("SITE_DOMAIN", "http://0.0.0.0:5000/");
define("SAVE_LINEUP_URI", SITE_DOMAIN . "save-lineup.php");
define("SHOW_LINEUP_URI", SITE_DOMAIN . "?lineup=");
define("ERROR_PAGE", SITE_DOMAIN . "error.html");
// For exploding in index.php and encoding in field.js.
define("VALUE_DELIMITER", ":;:");

?>
