<?php
	// Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("../variables.php");
	
	session_start ();
	session_destroy ();
	header ("Location: ".$link_login." ");
	exit ();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cache-control" content="no-cache"/>
	
	<title>Logout</title>
</head>
<body>

</body>
</html>