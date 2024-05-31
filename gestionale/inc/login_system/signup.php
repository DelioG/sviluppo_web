<?php
	
	// Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("../variables.php");
	require_once ($db_connection);
	require_once ($login_functions);

	$page_name        = $title_signup;
    $page_description = $description_signup;
    $page_keywords    = $keywords_signup;

	// ##################################################################################################### //
    // ##################################################################################################### //

	// Se viene cliccato il button per registrarsi
	if( $_SERVER["REQUEST_METHOD"] == "POST" )
	{
		
		$username 		   = $_POST['username'];
		$email 			   = $_POST['email'];
		$password 		   = $_POST['password'];
		$conferma_password = $_POST['conferma_password'];
		
		$result = registraUtente($conn, $username, $email, $password, $conferma_password);
		
		if( isset($result["success"]) )
		{
			$success = true;
			header("Location: signup_confirmed.php");
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
			<p class="descrizione">Registrazione Utente</p>
			<hr>
			<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
				<p>Username</p>
				<input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
				<br><br>
				<p>Email</p>
				<input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
				<br><br>
				<p>Password</p>
				<input type="password" id="password" name="password" required>
				<br><br>
				<p>Conferma Password</p>
				<input type="password" class="form-control" id="conferma_password" name="conferma_password" required>
				<br><br>
				<button type="submit" name="registrati" class="btn btn-primary">Registrati</button>
				<?php if ( isset($result["error"]) ) { ?>
					<p style="color: #f6685e; margin-top: 10px; text-align: center;"><?php echo htmlspecialchars($result["error"]); ?></p>
				<?php } ?>
			</form>
			<hr>
			<div class="to-login">
				oppure <a href="<?= $link_login; ?>">accedi</a>
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