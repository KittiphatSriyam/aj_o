<?php 

include '../config/database.php';

if(isset($_GET['username'])){
    
    $username = $_GET['username'];
 
    $sql = 'SELECT * FROM  `admin`  WHERE admin_username = :p1';
    $stm = $db->prepare($sql);
    $stm->execute([
        ':p1' => $username
       ]);
       
    $check_QR = $stm->fetch(PDO::FETCH_BOTH);
    
        if(empty($check_QR[0])){
            echo 'false';
        }else{
            echo $check_QR['admin_QR'];
        }
}