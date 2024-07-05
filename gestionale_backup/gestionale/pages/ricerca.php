<?php

    // Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("../inc/common_variables.php");
    require_once ($module_commonrequires);

    // Il title, la description e le keywords sono contenute nel file "inc/common_variables.php".
    $page_name        = $title_ricerca;
    $page_description = $description_ricerca;
    $page_keywords    = $keywords_ricerca;
    
    if ( isset ($_GET["ricerca"]) )
    {
        $ricerca           = $_GET["ricerca"];
        // $risultati_ricerca = avviaRicerca($conn, $ricerca);

        if ($risultati_ricerca == null)
        {
            // $error_message = "Nessun risultato trovato per [".$ricerca."]";
        }
    }
    else
    {
        // redirect alla home page
    }

?>
<!doctype html>
<html lang="it-IT">
<head>
    <?php require_once ($module_headtags); ?>
</head>
<body>

    <main>
        <div class="container">
            <div class="row">
                <?php require_once ($module_colsx); ?>
                <div class="col-dx" id="mainContent">
                    <div class="col-dx-container" id="colDxContainer">

                    </div> <!-- col-dx-container -->
                </div> <!-- col-dx | main-content -->
            </div> <!-- row -->
        </div> <!-- container -->
    </main>
    
    <?php require_once ($module_scripts); ?>
</body>
</html>