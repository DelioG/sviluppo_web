<?php
    // Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    // Includo inoltre il file che contiene tutte le funzioni necessarie al funzionamento del gestionale.
    require_once ("inc/variables.php");
    
    // Il title, la description e le keywords sono contenute nel file "inc/variables.php".
    $page_name        = $title_index;
    $page_description = $description_index;
    $page_keywords    = $keywords_index;

    session_start();

    // Se l'utente non è loggato, faccio il redirect al login
    if( !isset($_SESSION['utente']) )
    {
        header("Location: ".$link_login." ");
        exit;
    }
    else if ( isset($_SESSION['utente']) )
    {
        header("Location: ".$link_home." ");
        exit;
    }
?>
<!doctype html>
<html lang="it-IT">
<head>
   <?php require_once ($component_head_tags); ?>
</head>
<body>

    index

</body>
</html>