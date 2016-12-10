<?php

// outputs e.g.  somefile.txt was last changed: December 29 2002 22:16:23.

include_once('../lib/lib.import.inc.php');

$import = new import();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php $import->addCSS('../css/test.css')->importCSS(); ?>
    </body>
</html>
