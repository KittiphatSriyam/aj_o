<?php 

include '../config/database.php';

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
 
    $sql = 'SELECT * FROM `student` WHERE stu_id = :p1';
    $stm = $db->prepare($sql);
    $stm->execute([
        ':p1' => $id
       ]);
       
    $check_id = $stm->fetch(PDO::FETCH_BOTH);
    

        if(empty($check_id[0])){
            echo 'false';
        }else{
            echo 'true';
        }
}