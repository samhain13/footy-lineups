<?php

require_once "settings.php";
$field = new FieldProcessor();

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
            var save_action = "<?php echo SAVE_LINEUP_URI; ?>";
            var value_delimiter = "<?php echo VALUE_DELIMITER; ?>";
            var has_lineup = <?php echo count($field->lineup_settings); ?>;
        </script>
        <script src="static/field.js"></script>
    </head>
    <body>
        <h1>Football Line-Up</h1>
        <div id="pitch">
<?php $field->draw_players(); ?>
        </div>
        <div id="sidebar">
            <div id="gas-container"></div>
            <div id="share-id">
                Drag the black buttons to reposition players;<br />
                click the player labels to rename them.
<?php if ($field->has_lineup): ?>
                <br /><br />
                Share this lineup:<br />
                [ <a href="<?php $field->show_uri(); ?>"><?php $field->show_uri(); ?></a> ]
            </div>
            <div id="reset-button">Reset Lineup</div>
<?php else: ?>
            </div>
<?php endif; ?>
            <div id="save-button">Save Lineup</div>
        </div>
        <div style="clear:both;"></div>
    </body>
</html>
