<?php

$GLOBALS['LT_USERNAME'] = getenv('LT_USERNAME');
if (!$GLOBALS['LT_USERNAME']) {
    $GLOBALS['LT_USERNAME'] = "username";
}

$GLOBALS['LT_ACCESS_KEY'] = getenv('LT_ACCESS_KEY');
if (!$GLOBALS['LT_ACCESS_KEY']) {
    $GLOBALS['LT_ACCESS_KEY'] = "access_key";
}
?>
