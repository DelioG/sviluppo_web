<?php
	
	$type 	  = $db_type;
	$server   = $db_server;
	$db 	  = $db_name;
	$port 	  = $db_port;
	$charset  = $db_charset;
	
	$username = $db_username;
	$password = $db_password;
	
	$options  = 
	[
		PDO::ATTR_ERRMODE 			 => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES 	 => false,
	];
	
	$dsn = "$type:host=$server; dbname=$db; port=$port; charset=$charset";
	
	try
	{
		$conn = new PDO($dsn, $username, $password, $options);
	}
	catch (PDOException $e)
	{
		throw new PDOException($e->getMessage(), $e->getCode());
	}
	
?>