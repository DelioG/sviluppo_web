<?php
	
	// Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("../variables.php");
	require_once ($db_connection);
	require_once ($login_functions);

	$page_name        = $title_login;
    $page_description = $description_login;
    $page_keywords    = $keywords_login;

	// ##################################################################################################### //
    // ##################################################################################################### //

	session_start();
	
	// Se l'utente è già loggato, lo reindirizzo alla home
	if( isset($_SESSION['utente']) )
	{
		header("Location: ".$link_home." ");
		exit;
	}

	// Se viene cliccato il button per accedere
	if( $_SERVER["REQUEST_METHOD"] == "POST" )
	{
		
		$email 	  = $_POST['email'];
		$password = $_POST['password'];
		
		$result = loginUtente($conn, $email, $password);
		
		if( isset($result["success"]) )
		{
			$_SESSION["utente"] = $result["utente"];
			header("Location: ".$link_home." ");
			exit();
			$conn->close();
		}
		
	}
	
?>
<!doctype html>
<html lang="it-IT">
<head>
	<?php require_once ($component_head_tags); ?>
	<!-- Login System CSS -->
	<link rel="stylesheet" href="<?= $file_css_login_system; ?>">	
</head>
<body>
	
	<div class="container-form-signup-login">
		<div class="form-signup-login">
			<div class="brand">
				<a href="<?= $link_index; ?>">
					<?= $website_name; ?>
				</a>
			</div>
			<p class="descrizione">Login Utente</p>
			<hr>
			<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
				<p>Email</p>
				<input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
				<br><br>
				<p>Password</p>
				<input type="password" id="password" name="password" required>
				<br><br>
				<button type="submit" name="accedi" class="btn btn-primary">Accedi</button>
				<?php if ( isset($result["error"]) ) { ?>
					<p style="color: #f6685e; margin-top: 10px; text-align: center;"><?php echo htmlspecialchars($result["error"]); ?></p>
				<?php } ?>
			</form>
			<hr>
			<div class="to-login">
				oppure <a href="<?= $link_signup; ?>">registrati</a>
			</div>
		</div>
	</div>
	
</body>
</html>
<style>
	html, body
	{
		height: 100vh;
		width: 100vw;
	}
</style>