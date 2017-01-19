<?php error_reporting(-1);
	ini_set ("session.use_trans_sid", true);
	session_start();
	require_once('includes/connect_db.php');
	
	function CheckValidate() 
	{
		if ($_POST['login'] == "") return false; 
		if ($_POST['email'] == "") return false; 	
		if ($_POST['pass1'] == "") return false; 
		if ($_POST['pass2'] == "") return false; 
		if ($_POST['firstName'] == "") return false; 
		if ($_POST['lastName'] == "") return false;
		if (!isset($_POST['sex'])) return false; 
		if ($_POST['day'] == "День") return false;
		if ($_POST['month'] == "Месяц") return false;  
		if ($_POST['year'] == "Год") return false; 
		if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $_POST['email'])) return false; 
		if (!preg_match('/^([a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is', $_POST['login'])) return false; 
		if (strlen($_POST['pass1']) < 8) return false; 
 		if ($_POST['pass1'] != $_POST['pass2']) return false;

		$login = $_POST['login'];
		$rez_log = mysql_query("SELECT * FROM users WHERE login='" . $login . "' LIMIT 1");

		if (mysql_num_rows($rez_log) != 0) return false; 

		$email = $_POST['email'];
		$rez_email = mysql_query("SELECT * FROM users WHERE email='" . $email . "' LIMIT 1");
		if (mysql_num_rows($rez_email) != 0) return false; 
		
		return true; 
	}

	if (isset($_COOKIE['login']) && isset($_COOKIE['pass'])) 
	{
		header('Location: /filework.html');
	}
	else 
	{
		if (isset($_POST['OK'])) 
	{
		$check = CheckValidate(); 
		if ($check) 
		{
			$login = trim(htmlspecialchars($_POST['login']));
			$email = trim(htmlspecialchars($_POST['email']));
			$pass = htmlspecialchars($_POST['pass1']);
			$firstName = htmlspecialchars($_POST['firstName']);
			$lastName = htmlspecialchars($_POST['lastName']);
			$sex = $_POST['sex'];
			$day = $_POST['day'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			$birthDate = date($year . '.' . $month . '.' . $day);
		
			$pass = md5(md5($pass));

			if (mysql_query("INSERT INTO users (
				login,
				email,
				pass,
				firstName,
				lastName,
				sex,
				birthDate
				) VALUES ('".
				$login . "','" 
				. $email . "','"
				. $pass . "','" 
				. $firstName . "','" 
				. $lastName ."','" 
				. $sex . "','"
				. $birthDate ."')")) 
			{
				setcookie ("login", $login, (time() + 3600),"/","devtest");
				setcookie ("pass", md5($login.$pass), (time() + 3600),"/","devtest");
				@$res = mysql_query("SELECT * FROM users WHERE login=".$login);
				@$row = mysql_fetch_assoc($res);
				$_SESSION['id'] = $row['id'];

				header('Location: /filework.html');
			}
		}
		else
		{
			
			header('Location: /registration_bad.html');
		}
	}
	else
	{
		header('Location: /autorize.html');
	}
}
?>