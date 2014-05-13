<?php


require_once "settings.php";

$lineup = NULL;
$lines = array();
if (isset($_GET["lineup"])) {
    preg_match("/\W+/", $_GET["lineup"], $matches); // We don't want non-alnums.
    if (!$matches) {
        $fn = "lineups/" . $_GET["lineup"] . ".txt";
        if (file_exists($fn)) {
            $lineup = $_GET["lineup"];
            $handle = fopen($fn, "r");
            $counter = 1;
            foreach (explode("\n",
                str_replace("\r", "", fread($handle, filesize($fn)))) as $l) {
                if ($l) {
                    // The :;: delimiter needs to agree with the JavaScript.
                    $sl = explode(VALUE_DELIMITER, $l);
                    if (is_numeric($sl[0]) && is_numeric($sl[1])) {
                        array_push($lines, "<div id=\"player-" .$counter. "\" " .
                            "class=\"player\" data-label=\"" .
                            str_replace("\"",  "&quot;", $sl[2]). "\" " .
                            "style=\"left:" .  $sl[0] . "px;top:" .$sl[1]. "px;\"" .
                            "></div>\n");
                        $counter++;
                    } else {
                        $lineup = NULL;
                        break;
                    }
                }
            }
            fclose($handle);
        } else {
            header("Location: " . SITE_DOMAIN . "error.html");
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Football Line-Up</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="A simple PHP-JavaScript application that allows users to create football lineups and share them." />
        <link rel="stylesheet" href="static/styles.css"/>
        <script src="static/jquery.js"></script>
        <script>
            var save_action = "<?php echo SITE_DOMAIN; ?>save-lineup.php";
            var value_delimiter = "<?php echo VALUE_DELIMITER; ?>";
            var has_lineup = <?php echo count($lines); ?>;
        </script>
        <script src="static/field.js"></script>
    </head>
    <body>
        <h1>Football Line-Up</h1>
        <div id="pitch">
<?php if ($lineup != NULL): ?>
<?php     echo implode($lines, ""); ?>
<?php endif; ?>
        </div>
        <div id="sidebar">
            <div id="gas-container"></div>
            <div id="share-id">
                Drag the black buttons to reposition players;<br />
                click the player labels to rename them.
<?php if ($lineup != NULL): ?>
                <br /><br />Share this Lineup:<br />
                <a href="<?php echo SITE_DOMAIN . "?lineup=" . $lineup; ?>"><?php echo SITE_DOMAIN . "?lineup=" . $lineup; ?></a>
            </div>
            <div id="reset-button">Reset</div>
<?php else: ?>
            </div>
<?php endif; ?>
            <div id="save-button">Save Lineup</div>
        </div>
        <div style="clear:both;"></div>
    </body>
</html>
