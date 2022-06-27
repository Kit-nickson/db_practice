<?php

spl_autoload_register(function($class){
    require $class.'.php';
});

$db = new DB();
$debug = new DbDebug($db);



print '<pre>';
print_r($debug->select('blog', 'users', 'id = 2'));
print '</pre>';

