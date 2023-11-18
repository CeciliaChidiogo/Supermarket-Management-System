<?php
define("DB_NAME","supermarket");
define("DB_PASSWORD","root");
define("DB_SERVER","localhost");
define("DB_USER","root");

//start connection
$connect = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connect){
    die("database connection error".mysql_error());

}

$connect -> close();
?>