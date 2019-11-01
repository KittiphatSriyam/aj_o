<?php

session_start();
    
session_unset($_SESSION['borrow']);

?>

<script>
	alert('LOG OUT');
	window.location = './';
</script>