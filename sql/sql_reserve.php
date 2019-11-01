<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BCOM 01 Enterprise</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="./images/kmutnb-logo.ico" />
<?php

include '../config/database.php';

$EQUIP =$_POST['EQ'];

$newEQ = explode(",",$EQUIP);

$id = $_POST['id'];

$tel = $_POST['tel'];

$dateStart = $_POST['dateStart'];

$timestamp_start = strtotime($dateStart);

$dateEnd = $_POST['dateEnd'];

$timestamp_end = strtotime($dateEnd);

$location = $_POST['location'];

$count_EQ = count($newEQ);

if($count_EQ<=0){
    echo "<script>
            alert('กรุณาเลือกอุปกรณ์ที่จะยืม');
            window.location = '../';
         </script>"; 
    return false;
 }

$db->beginTransaction();
  
 
 for ($i=0; $i<$count_EQ; $i++) { 

    $sql_checkdate1 = "SELECT * FROM `borrow` WHERE (borrow_eqID = :p1) AND (:p2 BETWEEN `borrow_dateStart` AND `borrow_dateEnd`) AND ((borrow_status = :p3) || (borrow_status= :p4)) ORDER BY borrow_no  ASC";
    $stm1 = $db->prepare($sql_checkdate1);
    $stm1->execute([
        ':p1' => $newEQ[$i],
        ':p2' => $timestamp_start,
        ':p3' => '1',
        ':p4' => '2'
        
    ]);
    
    $numRows1 = $stm1->rowCount();

    $sql_checkdate2 = "SELECT * FROM `borrow` WHERE (borrow_eqID = :p1) AND (:p2 BETWEEN `borrow_dateStart` AND `borrow_dateEnd`) AND ((borrow_status = :p3) || (borrow_status= :p4)) ORDER BY borrow_no  ASC";
    $stm2 = $db->prepare($sql_checkdate2);
    $stm2->execute([
        ':p1' => $newEQ[$i],
        ':p2' => $timestamp_end,
        ':p3' => '1',
        ':p4' => '2'
        
    ]);
    
    $numRows2 = $stm2->rowCount();
    
    $sql_checkdate3 = "SELECT * FROM `borrow` WHERE (borrow_eqID = :p1) AND (`borrow_dateStart` BETWEEN :p2 AND :p3) AND ((borrow_status =:p4) || (borrow_status= :p5)) ORDER BY borrow_no ASC";
    $stm3 = $db->prepare($sql_checkdate3);
    $stm3->execute([
        ':p1' => $newEQ[$i],
        ':p2' => $timestamp_start,
        ':p3' => $timestamp_end,
        ':p4' => '1',
        ':p5' => '2'
    ]);
    
    $numRows3 = $stm3->rowCount();

    if($numRows1>=1 || $numRows2>=1 || $numRows3>=1){
        echo "<script>
    			alert('มีคนยืมไปแล้ว กรุณาตรวจสอบอีกครั้ง...');
    			window.history.back();
    		 </script>";
    	
    	$db->rollBack();
    	
    	return false;	 
    	
    }else{
        
    $sql = "INSERT INTO `borrow`(`borrow_stuID`, `borrow_tel`, `borrow_dateStart`, `borrow_dateEnd`, `borrow_location`, `borrow_eqID`, `borrow_status`) 
                                VALUES (:p1 , :p2 , :p3 , :p4 , :p5 , :p6, :p7)";
    $stm2 = $db->prepare($sql);
    $stm2->execute([
        ':p1' => $id,
        ':p2' => $tel,
        ':p3' => $timestamp_start,
        ':p4' => $timestamp_end, 
        ':p5' => $location,
        ':p6' => $newEQ[$i],
        ':p7' => '1'
      ]);
        
    }
    
 }
 
          echo " <script>
         		alert('ทำรายการสำเร็จ... รอการอนุมัติ');
         		window.location = '../';
        	</script>";
    
    $db->commit();


?>

</body>
</html>
