<?php

$db_host = 'localhost';
$db_name = 'borrow';
$username = 'root';
$password = '';

$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);
    
/************************************************************************************************/

    try {
        $db = new PDO("mysql:host=$db_host;dbname=$db_name", $username, $password, $option);
        // echo 'connect success';
        
    } catch (PDOException $e) {
        echo 'connect fail || '.$e->getMessage();
        
    }
    
    date_default_timezone_set("Asia/Bangkok");
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    