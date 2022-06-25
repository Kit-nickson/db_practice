<?php

spl_autoload_register(function($class){
    require $class.'.php';
});

$db = new DB();
$debug = new DbDebug($db);


// $debug->createTable('space', 'planets', [
//     'id' => 'int(11) PRIMARY KEY AUTO_INCREMENT',
//     'planet' => 'varchar(255)',
//     'water' => 'bool'
// ]);

// print_r($debug->getTableColumns('space', 'planets'));


// $debug->insert('space', 'planets', [
//     'planet' => 'Mercury',
//     'water' => '1'
// ]);

