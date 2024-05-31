<?php

	function validaUsername($username)
	{
		
		$pattern = '/^[a-zA-Z0-9_]{2,12}$/';
		
		if ( preg_match($pattern, $username) )
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}

	function registraUtente($conn, $username, $email, $password, $conferma_password)
	{
		
		if ( !empty($username) && !empty($email) && !empty($password) && !empty($conferma_password) )
		{	
	
			// USERNAME
			if( !validaUsername($username) )
			{
				$result["error"] = htmlspecialchars("Lo username deve contenere solo caratteri alfanumerici ed il carattere _");
			}
			else if (strlen($username) > 12)
			{
				$result["error"] = htmlspecialchars("Lo username deve essere composto da massimo 12 caratteri!");
			}
			// EMAIL
			else if (strlen($email) > 254)
			{
				$result["error"] = htmlspecialchars("L'email deve essere composta da massimo 254 caratteri!");
			}
			else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$result["error"] = htmlspecialchars("Il formato dell'email non è valido!");
			}
			// PASSWORD
			else if (strlen($password) < 8)
			{
				$result["error"] = htmlspecialchars("La password deve essere composta da almeno 8 caratteri!");
			}
			else if ($password != $conferma_password)
			{
				$result["error"] = htmlspecialchars("Le password non corrispondono!");
			}
			// SE TUTTO CORRETTO
			else if ( filter_var($email, FILTER_VALIDATE_EMAIL) && $password == $conferma_password && validaUsername($username) )
			{
				
				// Controllo se l'utente è già registrato sul database	
				$query_username =  $conn -> prepare("SELECT COUNT(*) as count FROM utenti WHERE username = :username");
				$query_email    =  $conn -> prepare("SELECT COUNT(*) as count FROM utenti WHERE email = :email");
				
				$query_username -> bindParam(':username', $username, PDO::PARAM_STR);
				$query_email    -> bindParam(':email',    $email,    PDO::PARAM_STR);
				
				$query_username -> execute();
				$query_email    -> execute();
				
				$stmt_username  =  $query_username ->fetch(PDO::FETCH_ASSOC);
				$stmt_email     =  $query_email    ->fetch(PDO::FETCH_ASSOC);
				
				$check_username =  $stmt_username['count'];
				$check_email    =  $stmt_email['count'];
				
				if ($check_username > 0)
				{
					$result["error"] = htmlspecialchars("Lo username utilizzato è già registrato!");
				}
				else if ($check_email > 0)
				{
					$result["error"] = htmlspecialchars("L'email utilizzata è già registrata!");
				}
				else if ($check_username > 0 && $check_email > 0)
				{
					$result["error"] = htmlspecialchars("Sia lo username che l'email utilizzati sono già registrati!");
				}
				else
				{	
					// Se l'utente non è presente nel database procedo a registrarlo
					$hashed_password = password_hash($password, PASSWORD_DEFAULT);
					
					$sql   = "INSERT INTO utenti (username, email, password) VALUES (:username, :email, :password)";
					$query = $conn->prepare($sql);
					
					$query -> bindParam(":username", $username,        PDO::PARAM_STR);
					$query -> bindParam(":email",    $email,           PDO::PARAM_STR);
					$query -> bindParam(":password", $hashed_password, PDO::PARAM_STR);
					
					$stmt  = $query->execute();
					
					$result["success"] = htmlspecialchars("Registrazione avvenuta");
				}
			}
			
		}
		else
		{
			$result["error"] = htmlspecialchars("Assicurati di aver riempito tutti i campi!");
		}
		
		return $result;
		
	}
	
	function loginUtente($conn, $email, $password)
	{
		
		if ( !empty($email) && !empty($password) )
		{	
			
			$query =  $conn -> prepare("SELECT COUNT(*) as count FROM utenti WHERE email = :email");
			$query -> bindParam(':email', $email, PDO::PARAM_STR);
			$query -> execute();
			$stmt  =  $query ->fetch(PDO::FETCH_ASSOC);
			$row   =  $stmt['count'];
			
			if($row > 0)
			{
				
				$query  =  $conn -> prepare("SELECT * FROM utenti WHERE email = :email");
				$query  -> bindParam(':email', $email, PDO::PARAM_STR);
				$query  -> execute();
				$utente =  $query ->fetch(PDO::FETCH_ASSOC);
				
				if ($utente && password_verify($password, $utente["password"]))
				{
					$result["success"] = htmlspecialchars("Utente verificato");
					$result["utente"] = $utente;
				}
				else
				{
					$result["error"] = htmlspecialchars("La password inserita non è corretta!");
				}
			}
			else
			{
				$result["error"] = htmlspecialchars("Nessun utente associato a questa email!");
			}
			
		}
		else
		{
			$result["error"] = htmlspecialchars("Assicurati di aver riempito tutti i campi!");
		}
		
		return $result;
	}

?>