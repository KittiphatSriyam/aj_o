<?php
session_start();
include './config/database.php';
include './libs/dateThai.php';

    $sql_Allow = 'SELECT borrow.*, student.* FROM  `borrow`  
                  INNER JOIN student ON borrow.borrow_stuID = student.stu_id 
                  WHERE borrow_status = :p1
                  GROUP BY  `borrow_stuID` ORDER BY  `borrow_no` ASC';
    $stm = $db->prepare($sql_Allow);
    $stm->execute([
        ':p1' => '1'
       ]);

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

    <table class="ui celled structured table selectable">
    
    <?php while($result_name = $stm->fetch(PDO::FETCH_BOTH)){ 
    
    $sql_EQ = 'SELECT borrow.*, equipment.* FROM  `borrow`  
                  INNER JOIN equipment ON borrow.borrow_eqID = equipment.EqID 
                  WHERE borrow_status = :p1 AND borrow_stuID = :p2
                  ORDER BY  `borrow_dateStart` ASC';
    $stm2 = $db->prepare($sql_EQ);
    $stm2->execute([
        ':p1' => '1',
        ':p2' => $result_name['borrow_stuID']
       ]);
    
    ?>  
        
    
      <thead>
        <tr>
          <th <?php if(isset($_SESSION['borrow'])){ echo 'colspan="5"'; }else{ echo 'colspan="4"';} ?>><?=$result_name['stu_name']?></th>
        </tr>
        <tr class="center aligned">
          <th>EQUIPMENT</th>
          <th>เริ่มตั้งเเต่</th>
          <th>จนถึง</th>
          <th>สถานที่</th>
          <?php if(isset($_SESSION['borrow'])){ ?>
          <th>ตัวเลือก</th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
    <?php while($result_EQ = $stm2->fetch(PDO::FETCH_BOTH)){ ?>
        <tr class="center aligned">
          <td><?=$result_EQ['EqName']?></td>
          <td><?=FormatThaiDate(date('Y-m-d H:i', $result_EQ['borrow_dateStart']), 'd M Y H:i')?>&ensp;น.</td>
          <td><?=FormatThaiDate(date('Y-m-d H:i', $result_EQ['borrow_dateEnd']), 'd M Y H:i')?>&ensp;น.</td>
          <td><?=$result_EQ['borrow_location']?></td>
          <?php if(isset($_SESSION['borrow'])){ ?>
          <td>
        <div class="ui buttons">
          <a class="ui green button" href="./sql/allow.php?id=<?=$result_EQ['borrow_no']?>">Agree</a>
          <div class="or"></div>
          <a class="ui button red" href="./sql/unAllow.php?id=<?=$result_EQ['borrow_no']?>">Dismiss</a>
        </div>
          </td>
          <?php } ?>
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