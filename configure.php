<?php
session_start();
include './config/database.php';

    $sql_EQ = 'SELECT * FROM `equipment`';
    $stm = $db->prepare($sql_EQ);
    $stm->execute();
       
    $sql2_EQ = 'SELECT * FROM `equipment` WHERE EQ_Status = :p1';
    $stm2 = $db->prepare($sql2_EQ);
    $stm2->execute([
        ':p1' => '1'
      ]);
      
  if(empty($_SESSION['borrow'])){ ?>
		<script>
 			alert('คุณไม่ได้รับอนุญาติให้ใช้งาน');
 			window.location = '../login.php';
		</script>
  <?php }

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
        <div class="ui raised segment">
            <form class="ui form" method="POST" action="sql/sql_eq.php">   
                <div class="two fields">
                    <div class="field">
                    <label>EQUIPMENT</label>
                        <select class="ui search dropdown" name="eq">
                            <option>SELECT EQUIPMENT</option>
                            <?php while($Eq_it = $stm->fetch(PDO::FETCH_BOTH)){ ?>  
                                <option value="<?=$Eq_it['EqID']?>"><?=$Eq_it['EqName']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="field">
                        <button class="ui violet basic button" style="margin-top:22px;">SUBMIT</button>
                    </div>
                </div>
            </form> 
            
            <table class="ui celled structured table selectable">
              <thead>
                <tr class="center aligned">
                  <th>ลำดับ</th>
                  <th>EQUIPMENT</th>
                </tr>
              </thead>
              <tbody>
            <?php $i=1; while($Eq_it2 = $stm2->fetch(PDO::FETCH_BOTH)){ ?>  
                <tr class="center aligned">
                  <td><?=$i++;?></td>
                  <td><?=$Eq_it2['EqName']?></td>
                </tr>
            <?php } ?>
              </tbody>
            </table>
        </div>
    </div>



<script>
$(document).ready(function(){
    
    $('.ui.labeled.icon.sidebar').first().sidebar('attach events', '.click-menu', 'show');

});
</script>    
</body>
</html>