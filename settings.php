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


// The class that drives the whole application.
class FieldProcessor {
    public $lineup_settings = array();     // Contains parsed player attributes.
    public $lineup_id = NULL;              // For easy access in making links.
    public $lineup_file = NULL;            // Relative path to the settings file.
    public $has_lineup = FALSE;            // For easy switching in our “views”.

    public function __construct() {
        $this->validate_lineup();
        // If we got a lineup_id but not a valid lineup_file, that's not good.
        if ($this->lineup_id && !$this->lineup_file) $this->show_error_page();
        // Parse if we have no problems.
        if ($this->lineup_file) $this->parse_lineup_file();
    }
    
    public function show_error_page() {
        /* Error page redirection, so we don't have to repeat it constantly. */
        header("Location: " . SITE_DOMAIN . "error.html");
    }
    
    public function draw_players($mode="html") {
        /* Mode can only be "html", for now. "svg" to follow. */
        $c = 1;
        foreach ($this->lineup_settings as $l) {
            switch ($mode) {
                case "html":
                    echo "<div id=\"player-" .$c. "\" class=\"player\"" .
                    " style=\"left:" .$l["x"]. "px;top:" .$l["y"].
                    "px;\" data-label=\"" .$l["label"]. "\"></div>";
                    break;
            }
            $c ++;
            echo "\n";
        }
    }
    
    public function show_uri($mode="html") {
        /* Returns the full URI of the lineup. Mode can only be "html" for now. */
        echo SHOW_LINEUP_URI . $this->lineup_id;
    }
    
    
    // ------------- Private methods for validating and parsing our lineup files.
    private function validate_lineup() {
        /* Get line-up settings based on user input, if any. */
        if (isset($_GET["lineup"])) {
            preg_match("/\W+/", $_GET["lineup"], $matches); // We don't want non-alnums.
            if (!$matches) {
                $this->lineup_id = $_GET["lineup"];
                $fn = "lineups/" . $_GET["lineup"] . ".txt";
                if (file_exists($fn)) $this->lineup_file = $fn;
            }
        }
        $this->has_lineup = $this->lineup_id && $this->lineup_file;
    }
    
    private function parse_lineup_file() {
        $handle = fopen($this->lineup_file, "r");
        foreach (explode("\n", str_replace("\r", "",
            fread($handle, filesize($this->lineup_file)))) as $l) {
            if ($l) {
                // The :;: delimiter needs to agree with the JavaScript.
                $sl = explode(VALUE_DELIMITER, $l);
                // We want x and y values that are numeric.
                if (is_numeric($sl[0]) && is_numeric($sl[1])) {
                    array_push($this->lineup_settings,
                        array("x" => $sl[0], "y" => $sl[1],
                        "label" => htmlspecialchars($sl[2]))
                    );
                // Otherwise, reset the lineup settings.
                } else {
                    $this->lineup_settings = array();
                    break;
                }
            }
        }
        fclose($handle);
    }

}

?>
