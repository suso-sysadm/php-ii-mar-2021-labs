<?php

define( 'BASE', realpath(__DIR__ . '/src') );

spl_autoload_register(
    function ($class) {
        $file = str_replace('\\', '/', $class) . '.php';
        require BASE . '/' . $file;
    }
);

use Customer\DbCustomer;

$customer=new DbCustomer('mysql','localhost','vagrant','vagrant','DBCustomer','User');
$customer->dbConnect();
$customer->dbCreate();
#$customer->tableCreate();
$customer->DbAddUser("perico1","palotes1","EYE1","ES");

$Users=$customer->StoredProcedure();
var_dump($users);
?>
