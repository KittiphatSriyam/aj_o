<?php 

include '../config/database.php';

session_start();

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    
    $sql_admin = 'SELECT * FROM  `admin`  WHERE admin_QR = :p1';
    $stm = $db->prepare($sql_admin);
    $stm->execute([
        ':p1' => $_SESSION['borrow']
       ]);
       
    $result_admin = $stm->fetch(PDO::FETCH_BOTH);

    $sql = "UPDATE `borrow` SET  `borrow_status` =  :p1,`borrow_admin` = :p2  WHERE  `borrow_no` = :p3";

    $stm2 = $db->prepare($sql);
    $stm2->execute([
        ':p1' => '2',
        ':p2' => $result_admin['admin_no'],
        ':p3' => $id
      ]);
       
		echo "<script>
		            alert('SUCCESS...');
    				window.location = '../allow.php';
    			</script>";
}