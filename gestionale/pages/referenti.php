<?php

    session_start();

    // Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("../inc/common_variables.php");
    require_once ($module_commonrequires);

    // Il title, la description e le keywords sono contenute nel file "inc/common_variables.php".
    $page_name        = $title_referenti;
    $page_description = $description_referenti;
    $page_keywords    = $keywords_referenti;
    
    /* ########################################################################### */
    /* ########################################################################### */
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $controller = new Controller();
        $result_msg = $controller -> insertNewReferente($_POST["cellulare"], $_POST["cognome"], $_POST["nome"] );

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
                                <p> <i title="Breve Introduzione" class="bi bi-info-circle"></i> Chi è il Referente? </p>
                                <p>
                                Un referente è colui che presenta la richiesta per l'iscrizione al banco alimentare o colui che è stato incaricato, 
                                tramite delega, di ritirare il pacco alimentare.
                                <br><br>
                                È quindi necessario che il numero di cellulare sia quello del referente, 
                                in modo da velocizzare le operazioni di contatto per notificare la possibilità di ricevere il pacco alimentare.
                                </p>
                            </div>
                            <div class="create-new">
                                <p class="create-new-heading">Anagrafica Referente</p>
                                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                                    <label>Cognome Referente: </label>
                                    <input maxlength="30" type="text" name="cognome" placeholder="Inserisci il cognome del referente..."   required>

                                    <label>Nome Referente: </label>
                                    <input maxlength="30" type="text" name="nome" placeholder="Inserisci il nome del referente..."      required>

                                    <label>Cellulare Referente: </label>
                                    <input maxlength="15" type="text" name="cellulare" placeholder="Inserisci il cellulare del referente..." required>

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

                                    <button type="submit" title="Inserisci nuovo referente">
                                        Inserisci Referente
                                    </button>

                                </form>
                            </div> <!-- -->
                        </div> <!-- container-createnew -->

                    </div> <!-- col-dx-container -->
                </div> <!-- col-dx | main-content -->
            </div> <!-- row -->
        </div> <!-- container -->
    </main>
    
    <?php require_once ($module_scripts); ?>
</body>
</html>