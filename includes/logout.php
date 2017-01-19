<?php
	setcookie('login', '', time() - 3600, '/', 'devtest'); 
	setcookie('pass', '', time() - 3600, '/', 'devtest');
	header('Location: /autorize.html');  
?>