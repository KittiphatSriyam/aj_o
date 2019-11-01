<?php
session_start();
include './config/database.php';

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
        <div class="ui two column centered grid">
          <div class="column">
            <form class="ui form" method="post" action="./sql/sql_login.php">    
              <div class="field">
                <input type="text" name="username" id="username" placeholder="USERNAME" maxlength="30" />
              </div>
              
              <div class="field input">
                  <img id="qrImg" />
              </div>
              <div class="field">
                  <span id="otpInput" />
              </div>
              <input type="hidden" name="secret" id="secret">
              <button class="ui purple basic button">SUBMIT</button>
            </form>
          </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://caligatio.github.io/jsSHA/sha.js"></script>
<script type="text/javascript" src="./libs/js/QR.js"></script>
<script>
$(document).ready(function(){
    $('.ui.labeled.icon.sidebar').first().sidebar('attach events', '.click-menu', 'show');

    $('input[name="username"]').on("keyup",function(){
        var username = $('input[name="username"]').val();
        $.ajax({
            method: "GET",
            url: "./sql/check_QR.php",
            data: { username: username}
        }).done(function(msg) {
              if(msg!='false'){
                  $('#secret').val(msg);
                  $('#qrImg').show();
                  $('#otpInput').html('<input type="text" name="otpInput" id="otpInput" placeholder="OTP" maxlength="6" />')
                  updateOtp();
              }else{
                $('#otpInput').html('<div class="ui red message">NOT FOUND</div>');
                $('input[name="username"]').focus();
                $('#qrImg').hide();
              }
        });
    }); 
    setInterval(timer, 1000);
});
</script>    
</body>
</html>