<?php

    session_start();

    // Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("../inc/common_variables.php");
    require_once ($module_commonrequires);

    // Il title, la description e le keywords sono contenute nel file "inc/common_variables.php".
    $page_name        = $title_famiglie;
    $page_description = $description_famiglie;
    $page_keywords    = $keywords_famiglie;
    
    /* ########################################################################### */
    /* ########################################################################### */

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $controller = new Controller();
        $result_msg = $controller->insertNewFamiglia($_POST["numero_fascicolo"], $_POST["note"], $_POST["componenti_minorenni"], $_POST["componenti_totali"] );

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
                                    <p> <i title="Breve Introduzione" class="bi bi-info-circle"></i> Informazioni sulle Famiglie</p>
                                    <p>
                                        Per facilitare la tracciabilità delle distribuzioni e degli utenti, 
                                        ricorda di assegnare un referente alla nuova famiglia. 
                                        <br><br>
                                        Ogni famiglia può avere un solo referente. Se preferisci, puoi anche assegnare la famiglia a una singola zona per semplificare il tracciamento delle distribuzioni.
                                    </p>
                                </div>
                                <div class="create-new">
                                    <p class="create-new-heading">Dettagli Famiglia</p>
                                    <form method="POST" action="">

                                        <label>Numero Fascicolo: </label>
                                        <input type="number" name="numero_fascicolo" placeholder="Inserisci il numero di fascicolo della famiglia..." min="1" required>

                                        <label>Note Famiglia: </label>
                                        <input type="text" name="note" placeholder="Inserisci eventuali note sulla famiglia..." maxlength="256">

                                        <label>Componenti < 16: </label>
                                        <input type="number" name="componenti_minorenni" id="famigliaComponentiMinorenni" placeholder="Inserisci il numero dei componenti con età minore di 16 anni nella famiglia..." min="0" value="0" required>

                                        <label>Componenti Totali: </label>
                                        <input type="number" name="componenti_totali" id="famigliaComponentiTotali" placeholder="Inserisci il numero dei componenti totali nella famiglia... (compresi quelli < 16)" min="1" value="1" required>

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

                                        <button type="submit" title="Inserisci nuovo prodotto">
                                            Crea Famiglia
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
    <script>

        // Questo codice serve a gestire l'aumento dei componenti se vengono settati i componenti minorenni (<16)
        // Se ad esempio viene settato il numero di componenti minorenni su 3, automaticamente il campo dei componenti totali, aumenterà.
        const minoriInput = document.getElementById('famigliaComponentiMinorenni');
        const totaliInput = document.getElementById('famigliaComponentiTotali');

        minoriInput.addEventListener('input', function() 
        {
            let minori = parseInt(minoriInput.value) || 0;
            let totali = parseInt(totaliInput.value) || 1;

            // Impedisce valori negativi
            if (minori < 0) 
            {
                minori = 0;
                minoriInput.value = minori;
            }

            // Se minori aumenta e diventa uguale o maggiore a totali, incrementa totali
            if (minori >= totali) 
            {
                totali = minori + 1;
            }

            // Se minori diminuisce, diminuisce anche totali
            if (minori < totali - 1) 
            {
                totali = minori + 1;
            }

            totaliInput.value = totali;
        });

        totaliInput.addEventListener('input', function() 
        {
            let minori = parseInt(minoriInput.value) || 0;
            let totali = parseInt(totaliInput.value) || 1;

            // Impedisce valori negativi
            if (totali < 1) 
            {
                totali = 1;
                totaliInput.value = totali;
            }

            // Se totali scende sotto minori + 1, resetta minori a 0
            if (totali < minori + 1) 
            {
                minoriInput.value = 0;
            }
        });
        
    </script>
</body>
</html>