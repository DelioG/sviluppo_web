<?php
    require_once ("../inc/variables.php");
    require_once ($functions);
    require_once ($db_connection);

    require_once($component_session_check);
    
    $page_name        = $title_dettaglio;
    $page_description = $description_dettaglio;
    $page_keywords    = $keywords_dettaglio;

    // ######################################################################################## //
    // ######################################################################################## //

    if( isset($_GET["id"]) && isset($_GET["tipo"]) )
    {
        $tipo = $_GET["tipo"];
        $id   = $_GET["id"];

        switch ($tipo)
        {
            case "zona":
                $result = getZonaById($conn, $id);
                if ( $result == null )
                    $error_message = "La zona che stai cercando non esiste.";
                break;

            case "famiglia":
                $result = getFamigliaById($conn, $id);
                if ( $result == null )
                    $error_message = "La famiglia che stai cercando non esiste.";
                break;

            case "referente":
                $result = getReferenteById($conn, $id);
                if ( $result == null )
                    $error_message = "Il referente che stai cercando non esiste.";
                break;

            case "prodotto":
                $result = getProdottoById($conn, $id);
                if ( $result == null )
                    $error_message = "Il prodotto che stai cercando non esiste.";
                break;

            case "distribuzione":
                $result = getDistribuzioneById($conn, $id);
                if ( $result == null )
                    $error_message = "La distribuzione che stai cercando non esiste.";
                break;

            default:
                break;
        }
        
    }
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

                dettaglio
                
            </div> <!-- container -->
        </div> <!-- col-dx -->
    </div> <!-- row -->

    <?php require_once($component_scripts); ?>
</body>
</html>