<?php

    session_start();

    // Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("../inc/common_variables.php");
    require_once ($module_commonrequires);

    // Il title, la description e le keywords sono contenute nel file "inc/common_variables.php".
    $page_name        = $title_zone;
    $page_description = $description_zone;
    $page_keywords    = $keywords_zone;
    
    /* ########################################################################### */
    /* ########################################################################### */

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $controller = new Controller();
        $result_msg = $controller -> insertNewZona($_POST["nome"]);

        // Memorizza il messaggio di risultato in una sessione per visualizzarlo dopo il reindirizzamento
        $_SESSION['result_msg'] = $result_msg;

        // Reindirizza l'utente alla stessa pagina per evitare duplicazioni
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Recupera il messaggio di risultato dalla sessione, se presente
    if (isset($_SESSION['result_msg'])) 
    {
        $result_msg = $_SESSION['result_msg'];

        // Rimuovi il messaggio dopo averlo visualizzato
        unset($_SESSION['result_msg']);
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

                            <div class="container-create-new">
                                <div class="tutorial">
                                    <p> <i title="Breve Introduzione" class="bi bi-info-circle"></i> Cosa sono le Zone?</p>
                                    <p>
                                        Ad una Zona sono assegnate più Famiglie.
                                        <br><br>
                                        Ogni famiglia è assegnata esclusivamente a una zona specifica, facilitando il monitoraggio delle consegne all'interno di ogni quartiere.
                                        <br><br>
                                        Questo approccio garantisce una migliore tracciabilità delle distribuzioni ai residenti, 
                                        riducendo così possibili lamentele nel caso in cui una famiglia non sia stata chiamata per ritirare il pacco insieme alle altre dello stess quartiere o zona di residenza.
                                    </p>
                                </div>
                                <div class="create-new">
                                    <p class="create-new-heading">Crea nuova Zona</p>
                                    <form method="POST" action="">

                                        <label>Nome della Zona: </label>
                                        <input type="text" name="nome" placeholder="Inserisci il nome della zona..." maxlength="30" required>

                                        <div class="status-msgs">
                                            <?php
                                                if (isset($result_msg) && !empty($result_msg) && is_array($result_msg)) 
                                                {
                                                    if (!$result_msg["status"]) 
                                                    {
                                                        echo '<p class="error">Errore: ' . htmlspecialchars($result_msg["message"]) . '.</p>';
                                                    } 
                                                    else 
                                                    {
                                                        echo '<p class="success">Avviso: ' . htmlspecialchars($result_msg["message"]) . '.</p>';
                                                    }
                                                }
                                            ?>
                                        </div>

                                        <button type="submit" title="Inserisci nuova Zona">
                                            Crea Zona
                                        </button>

                                    </form>
                                </div> <!-- -->
                            </div> <!-- container-createnew -->

                            <hr>

                    </div> <!-- col-dx-container -->
                </div> <!-- col-dx | main-content -->
            </div> <!-- row -->
        </div> <!-- container -->
    </main>
    
    <?php require_once ($module_scripts); ?>
</body>
</html>