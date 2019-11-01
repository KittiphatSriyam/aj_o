<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BCOM 01 Enterprise</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="./images/kmutnb-logo.ico" />
<?php

session_start();

include '../libs/rfc6238.php';

$secretkey = $_POST['secret'];
$currentcode = $_POST['otpInput'];


	if (TokenAuth6238::verify($secretkey,$currentcode)) {
				$_SESSION['borrow'] = $secretkey;

				echo "<script>
            				window.location = '../allow.php';
            			</script>";
	} else {
				echo "<script>
				            alert('ERROR: LOGIN FAIL.');
            				window.location = '../login.php';
            			</script>";
	}


?>
</body>
</html>
