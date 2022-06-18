<?php

spl_autoload_register(function($class){
    require $class.'.php';
});

$db = new DB();
$debug = new DbDebug($db);

// $db->createDB('space');
// $db->createTable('space', 'planets', [
//     'id' => 'int(11)',
//     'name' => 'varchar(255)',
//     'moons' => 'int(11)',
//     'water' => 'boolean'
//     ,]);

// $db->deleteTable('space', 'planets2');

// $db->getRandom();

$debug->createTable('space', 'planets', [
        'id' => 'int(11)',
        'name' => 'varchar(255)',
        'moons' => 'int(11)',
        'water' => 'boolean'
        ,]);

