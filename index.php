<?php


require_once "settings.php";

$lineup = NULL;
if (isset($_GET["lineup"])) {
    preg_match("/\W+/", $_GET["lineup"], $matches); // We don't want non-alnums.
    if (!$matches) {
        $fn = "lineups/" . $_GET["lineup"] . ".txt";
        if (file_exists($fn)) {
            $lineup = $_GET["lineup"];
            $handle = fopen($fn, "r");
            $lines = array();
            /*
                Originally, I saved the whole script in the text file as:
                    var lineup = [ ... ];
                But I figured that it's too un-secure. Not to say that the
                following procedure addresses the whole security issue but
                I figured it should be better than nothing-- even slightly.
                -- Samhain13
            */
            foreach (explode("\n",
                str_replace("\r", "", fread($handle, filesize($fn)))) as $l) {
                if ($l) {
                    // The :;: delimiter needs to agree with the JavaScript.
                    $sl = explode(VALUE_DELIMITER, $l);
                    array_push($lines, "{\"left\": ". $sl[0] .
                    ", \"top\": " .$sl[1]. ", \"label\": \"" . $sl[2] . "\"}");
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
<?php if ($lineup != NULL): ?>
            var lineup = [
                <?php echo implode(",\n                ", $lines) . "\n"; ?>
            ];
<?php else: ?>
            var lineup = null;
<?php endif; ?>
        </script>
        <script src="static/field.js"></script>
    </head>
    <body>
        <h1>Football Line-Up</h1>
        <div id="pitch"></div>
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
