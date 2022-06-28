<?php

spl_autoload_register(function($class){
    require $class.'.php';
});

$db = new DB();
$debug = new DbDebug($db);



print '<pre>';
print_r($debug->select('space', 'planets', 'water = 1'));
print '</pre>';

