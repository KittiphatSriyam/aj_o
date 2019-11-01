<?php
session_start();
include './config/database.php';
include './libs/dateThai.php';

$month = @$_POST['month'];
$year = @$_POST['year'];

    $sql_Allow = 'SELECT borrow.*, student.* FROM  `borrow`  
                  INNER JOIN student ON borrow.borrow_stuID = student.stu_id 
                  WHERE borrow_status = :p1 AND MONTH( FROM_UNIXTIME(`borrow_dateStart`) ) = :p2 AND YEAR( FROM_UNIXTIME(  `borrow_dateStart` ) ) =  :p3
                  GROUP BY  `borrow_stuID` ORDER BY  `borrow_no` ASC';
    $stm = $db->prepare($sql_Allow);
    $stm->execute([
        ':p1' => '3',
        ':p2' => $month,
        ':p3' => $year
       ]);
       
    $sql_Year = "SELECT DATE_FORMAT(FROM_UNIXTIME(`borrow`.`borrow_dateStart`), '%Y') AS dateYEAR, DATE_FORMAT(FROM_UNIXTIME(`borrow`.`borrow_dateStart`), '%Y-%m-%d') AS date FROM  `borrow` WHERE borrow_status = :p1 GROUP BY dateYEAR";
    $stm3 = $db->prepare($sql_Year);
    $stm3->execute([
        ':p1' => '3'
       ]);
       
    $dateThai = array( "","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BCOM 01 Enterprise</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/kmutnb-logo.ico" />
    <script src="https://use.fontawesome.com/c9ae3f94a6.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css"/>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="  crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>

</head>
<body>
    
  <?php include './slidebar.php'; ?>
  
    <div class="ui container" style="margin-top:20px;">
        <form class="ui equal width form" method="post">
          <div class="fields">
            <div class="field">
                <select class="ui search dropdown" name="month">
                    <option value="NULL">เลือกเดือน</option>
                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php echo $_POST['month'] == $i ? 'selected' : '';  ?> ><?php echo $dateThai[$i]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="field">
                <select class="ui search dropdown" name="year">
                  <option value="00">เลือกปี</option>
                  <?php while($result_Year = $stm3->fetch(PDO::FETCH_BOTH)){ ?>
                  <option value="<?=$result_Year['dateYEAR']?>"  <?php echo $_POST['year'] == $result_Year['dateYEAR'] ? 'selected' : '';  ?> ><?=FormatThaiDate($result_Year['date'], 'Y')?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="field">
                <button class="ui secondary basic button">SUBMIT</button>
            </div>
          </div>
        </form>
    </div>
   
    <table class="ui celled structured table selectable">
    
    <?php while($result_name = $stm->fetch(PDO::FETCH_BOTH)){ 
    
    $sql_EQ = 'SELECT borrow.*, equipment.*, nameadmin.admin_name AS admin , nameadminreturn.admin_name AS admin_return FROM  `borrow`  
                  INNER JOIN equipment ON borrow.borrow_eqID = equipment.EqID 
                  INNER JOIN admin nameadmin ON borrow.borrow_admin = nameadmin.admin_no
                  INNER JOIN admin nameadminreturn ON borrow.borrow_adminReturn = nameadminreturn.admin_no
                  WHERE borrow_status = :p1 AND borrow_stuID = :p2 AND MONTH( FROM_UNIXTIME(`borrow_dateStart`) ) = :p3 AND YEAR( FROM_UNIXTIME(  `borrow_dateStart` ) ) =  :p4
                  ORDER BY  `borrow_dateStart` ASC';
    $stm2 = $db->prepare($sql_EQ);
    $stm2->execute([
        ':p1' => '3',
        ':p2' => $result_name['borrow_stuID'],
        ':p3' => $month,
        ':p4' => $year
       ]);
    
    ?>  
        
    
      <thead>
        <tr>
          <th <?php if(isset($_SESSION['borrow'])){ echo 'colspan="7"'; }else{ echo 'colspan="8"';} ?>><?=$result_name['stu_name']?></th>
        </tr>
        <tr class="center aligned">
          <th>EQUIPMENT</th>
          <th>เริ่มตั้งเเต่</th>
          <th>จนถึง</th>
          <th>สถานที่</th>
          <th>ผู้อนุมัติ</th>
          <th>ผู้รับคืน</th>
        </tr>
      </thead>
      <tbody>
    <?php while($result_EQ = $stm2->fetch(PDO::FETCH_BOTH)){ ?>
        <tr class="center aligned">
          <td><?=$result_EQ['EqName']?></td>
          <td><?=FormatThaiDate(date('Y-m-d H:i', $result_EQ['borrow_dateStart']), 'd M Y H:i')?>&ensp;น.</td>
          <td><?=FormatThaiDate(date('Y-m-d H:i', $result_EQ['borrow_dateEnd']), 'd M Y H:i')?>&ensp;น.</td>
          <td><?=$result_EQ['borrow_location']?></td>
          <td><?=$result_EQ['admin']?></td>
          <td><?=$result_EQ['admin_return']?></td>
        </tr>
      </tbody>
    <?php } ?>
    <?php } ?>
    </table>

<script>
$(document).ready(function(){
    
    $('.ui.labeled.icon.sidebar').first().sidebar('attach events', '.click-menu', 'show');

});
</script>    
</body>
</html>