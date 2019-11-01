<?php
session_start();
include './config/database.php';
include './libs/dateThai.php';

    $sql = 'SELECT * FROM equipment';
    $stm = $db->prepare($sql);
    $stm->execute();

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

            <img class="ui medium rounded image" src="./images/logo.jpg" style="width:150px;"/>

    
    
    <div class="ui raised segment">
        <form class="ui form" method="post" action="./sql/sql_reserve.php">
            <div class="two fields">
              <div class="field">
                <input type="text" name="id" id="id" placeholder="STUDENT ID" maxlength="13" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}"/>
              </div>
              <div class="field">
                <div id="feedback"></div>
              </div>
            </div>
            <div class="two fields">
              <div class="field">
                <input type="text" name="tel" id="tel" placeholder="TELEPHONE" maxlength="10" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}"/>
              </div>
            </div>
          <div class="ui form">
            <div class="two fields">
              <div class="field">
                <label>Start date</label>
                <div class="ui calendar" id="rangestart">
                  <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input type="text" name="dateStart" id="dateStart" placeholder="Start     EX.19/01/2018 08:00">
                  </div>
                </div>
              </div>
              <div class="field">
                <label>End date</label>
                <div class="ui calendar" id="rangeend">
                  <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input type="text" name="dateEnd" id="dateEnd" placeholder="End  EX.19/01/2018 16:00">
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="two fields">
          <div class="field">
            <input type="text" name="location" id="location" placeholder="LOCATION">
          </div>
        </div>  
       <h4 class="ui dividing header">EQUIPMENT</h4>
         <div class="field">
            <div class="ui fluid multiple search selection dropdown">
              <input type="hidden" name="EQ">
              <i class="dropdown icon"></i>
              <div class="default text">SELECT EQUIPMENT</div>
              <div class="menu">
                <?php while($Eq_it = $stm->fetch(PDO::FETCH_BOTH)){ ?>  
                <div class="item" data-value="<?=$Eq_it['EqID']?>" data-text="<?=$Eq_it['EqName']?>">
                  <img class="ui mini avatar image" src=".<?=$Eq_it['EQ_img']?>">
                  <?=$Eq_it['EqName']?>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>

            <button class="ui purple basic button">SUBMIT</button>
        </form>
    </div>
</div>


<script>
$(document).ready(function(){
    
    var today = new Date();

    $('input[name="id"]').on("change",function(){
        var id = $('input[name="id"]').val();
        if(id!=null){
          $.ajax({
            method: "GET",
            url: "./sql/check_id.php",
            data: { id: id}
          }).done(function(msg) {
            if(msg=='true'){
               $('#feedback').html('<div class="ui green message">SUCCESSFUL</div>');
            }else{
              $('#feedback').html('<div class="ui red message">NOT FOUND</div>');
              $('input[name="id"]').focus();
            }
          });
          return false;
          
        }
      }); 

    $('.ui.labeled.icon.sidebar').first().sidebar('attach events', '.click-menu', 'show');
    
    $('#rangestart').calendar({
      endCalendar: $('#rangeend'),
        formatter: {
            date: function (date, settings) {
              if (!date) return '';
              var day = date.getDate();
              var month = date.getMonth() + 1;
              var year = date.getFullYear();
              return day + '-' + month + '-' + year;
            }
        },
      ampm: false,
      minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate())
    });
    
    $('#rangeend').calendar({
      startCalendar: $('#rangestart'),
        formatter: {
            date: function (date, settings) {
              if (!date) return '';
              var day = date.getDate();
              var month = date.getMonth() + 1;
              var year = date.getFullYear();
              return day + '-' + month + '-' + year;
            }
        },
      ampm: false
    });

    $('.dropdown').dropdown({
        transition: 'drop'
      });
            
});
</script>
</body>
</html>
