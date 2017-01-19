<?php error_reporting(-1);
	require_once('connect_db.php');
	ini_set ("session.use_trans_sid", true);
	session_start();
	function CheckValidate() 
	{
		if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $_POST['email'])) return false; 
		if (strlen($_POST['pass']) < 8) return false; 
		$email = htmlspecialchars($_POST['email']);
		$rez_email = mysql_query("SELECT * FROM users WHERE email='" . $email . "' LIMIT 1");
		if (mysql_num_rows($rez_email) == 0) return false; 
		$pass = htmlspecialchars($_POST['pass']);
		$pass = md5(md5($pass));
		$rez_pass = mysql_query("SELECT * FROM users WHERE pass='" . $pass . "' LIMIT 1");
		if (mysql_num_rows($rez_pass) == 0) return false; 
		return true;
	}

	if (isset($_COOKIE['login']) && isset($_COOKIE['pass'])) 
	{
		header('Location: /filework.html');
	}
	else 
	{
	
		$check = CheckValidate(); 
		if ($check) 
			{
				$email = htmlspecialchars($_POST['email']);
				@$res = mysql_query("SELECT * FROM users WHERE email='" . $email . "' LIMIT 1");

				@$row = mysql_fetch_assoc($res);
				$pass = htmlspecialchars($_POST['pass']);
				$pass = md5(md5($pass));

				setcookie ("login", $row['login'], (time() + 3600),"/","devtest");
				setcookie ("pass", md5($row['login'].$pass), (time() + 3600),"/","devtest");
				
				$_SESSION['id'] = @$row['id'];
				header('Location: /filework.html');
			}
		else 
			echo header('Location: /autorize.html');
	}
?>