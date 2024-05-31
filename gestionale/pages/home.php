<?php
    // Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    // Includo inoltre il file che contiene tutte le funzioni necessarie al funzionamento del gestionale.
    require_once ("../inc/variables.php");
    require_once ($functions);

    require_once($component_session_check);

    // Il title, la description e le keywords sono contenute nel file "inc/variables.php".
    $page_name        = $title_home;
    $page_description = $description_home;
    $page_keywords    = $keywords_home;

    // ######################################################################################## //
    // ######################################################################################## //
	
?>
<!doctype html>
<html lang="it-IT">
<head>
   <?php require_once ($component_head_tags); ?>
</head>
<body>

    <?php require_once ($component_navbar) ?>
    
    <div class="row">
        <?php require_once ($component_col_sx) ?>
        <div class="col-dx" id="coldx">
            <?php require_once ($component_path) ?>
            <div class="container">
                Home
            </div> <!-- container -->
        </div> <!-- col-dx -->
    </div> <!-- row -->

    <?php require_once($component_scripts); ?>
</body>
</html>