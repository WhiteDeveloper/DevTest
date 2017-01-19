<?php error_reporting(-1);
	require_once('connect_db.php');
	try
	{
		if( !empty($_FILES) )
		{	
			$filePath = "D:/Settings/OpenServer/domains/DevTest/uploads/";
			$fileName = $filePath . $_FILES['file']['name'];
			$fileIndex = 0; 
			$tmpFileName = $_FILES['file']['name'];
			while (1) 
			{
				if (file_exists($fileName))
				{
					$fileName = $filePath . $fileIndex . $_FILES['file']['name'];
					$tmpFileName = $fileIndex . $_FILES['file']['name'];
				}
				else break;
				$fileIndex++;
			}
			
			move_uploaded_file($_FILES['file']['tmp_name'], $fileName);
		
		$id = mysql_query("SELECT id_user FROM users WHERE login='" . @$_COOKIE['login'] . "'");
		@$row = mysql_fetch_array($id);

		$id_user = (int)$row['id_user'];

		if(mysql_query("INSERT INTO LoadFiles (
				id_user, fileName, url,	fileSize) VALUES (
				".	$id_user . ",'"  . $tmpFileName . 
				"','" . $fileName . "'," 	. $_FILES['file']['size'] 
				. ")"))

		{
			echo "<html><head><link rel='stylesheet' type='text/css' href='/style.css'></head><body><h3>Файл успешно загружен</h3><br/><center><a href='/filework.html'>Назад</a></center></body</html>" ;
		}
	}
	}
	catch(Exception $e)
	{
		echo  $e->getMessage();
	}


        		
?>