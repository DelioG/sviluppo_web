<?php

    session_start();

    // Se l'utente non è loggato, faccio il redirect al login
    if( !isset($_SESSION['utente']) )
    {
        header("Location: ".$link_login." ");
        exit;
    }
    else if ( isset($_SESSION['utente']) )
    {
        $utente = $_SESSION["utente"];
    }

?>