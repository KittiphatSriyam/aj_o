<?php 
 session_start();
 include ('../config/database.php');
 
$eq = $_POST['eq'];


$check_stat ='SELECT * FROM  `equipment` WHERE EqID = :p1';
$stm = $db->prepare($check_stat);
$stm->execute([
    ':p1' => $eq
   ]);
   
$result = $stm->fetch(PDO::FETCH_BOTH);

if($result['EQ_Status']=='0'){
	$stat = 1 ;
}else{
	$stat = 0 ;
}
	
$update ='UPDATE equipment SET  EQ_Status = :p1 WHERE EqID = :p2';
$stm2 = $db->prepare($update);
$stm2->execute([
    ':p1' => $stat,
    ':p2' => $eq
   ]);

 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <title>EGAT</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="shortcut icon" type="image/x-icon" href="../img/egat.ico" />
 
		<script>
 			alert('Success');
 			window.location = '../configure.php';
		</script>
		
</body>
</html>