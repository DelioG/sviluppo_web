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
    /* VERIFICA CONNESSIONE AL DATABASE                                            */
    /* ########################################################################### */

    // Verifico prima se il database è disponibile, altrimenti la pagina non viene proprio caricata.

    try 
    {
        // Prova a fare una query semplice per verificare la connessione
        Controller::checkDatabaseConnection();
    }
    catch (PDOException $e) 
    {
        // Se c'è un'eccezione, il database non è disponibile
        // Crea un messaggio di errore da passare alla pagina di errore
        $errorMessage = urlencode('Errore: impossibile stabilire una connessione con il database.');
        $redirectUrl = $link_error . '?error=' . $errorMessage;

        // Reindirizza l'utente ad un'altra pagina con il messaggio di errore
        header("Location: " . $redirectUrl);
        exit;
    }

    /* ########################################################################### */
    /* AL CARICAMENTO O AL REFRESH DELLA PAGINA                                    */
    /* ########################################################################### */

    // Codice eseguito al caricamento della pagina.
    $controller = new Controller();
    $total_records = $controller -> getAllZone();

    // Assegnazione effettuata per ritorane il numero di records trovati al "select_print.php".
    $records_found = $total_records["zone"];
    // Assegnazione effettuata semplicemente per migliorare la leggibilità del codice su questa pagina.
    $zone = $records_found;

    // Se non ci sono Prodotti nel database, credo un messaggio d'errore...
    if ( $zone == null )
    {
        $total_records_error_msg = "Non sono presenti Zone nel database";
    }

    /* ########################################################################### */
    /* INSERIMENTO NUOVA ZONA - [RICHIESTA POST]                                   */
    /* ########################################################################### */

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $controller = new Controller();
        $result_msg = $controller -> insertNewZona($_POST["nome"]);

        // Memorizza il messaggio di risultato in una sessione per visualizzarlo dopo il reindirizzamento
        $_SESSION['result_msg'] = $result_msg;
        $_SESSION['nome']    = $_POST['nome'];

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

    // Inserire gli altri metodi per l'ordinamento, per favore.

    /* ########################################################################### */
    /* ORDINAMENTO DEI PRODOTTI - [RICHIESTA GET]                                  */
    /* ########################################################################### */
    
    // Codice utilizzato per l'ordinamento degli array quando l'utente clicca su un qualsiasi ordinamento della tabella.
    if ( isset($_GET['sort_by']) ) 
    {
        $sort_type = $_GET['sort_by'];
        $order     = $_GET['order'];

        switch ($sort_type)
        {

            case 'zona_nome':
                $zone = Controller::ordinamentoAlfabetico ($records_found, $order, null, "getNome");
                break;

            case 'zona_totale_famiglie':
                $zone = Controller::ordinamentoNumerico ($records_found, $order, null, "getNumeroFamiglie");
                break;

            case 'zona_somma_componenti_totali':
                $zone = Controller::ordinamentoNumerico ($records_found, $order, null, "getSommaComponentiTotali");
                break;
            
            case 'zona_somma_componenti_minorenni':
                $zone = Controller::ordinamentoNumerico ($records_found, $order, null, "getSommaComponentiMinorenni");
                break;

            default:
                break;
        }

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

                            <!-- ####################################### -->
                            <!-- [INIZIO NUOVO ELEMENTO]                 -->
                            <!-- Inserimento nuova Zona                  -->

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
                                        <input type="text" name="nome" placeholder="Inserisci il nome della zona..." maxlength="30" value="<?php echo isset($_SESSION['nome']) ? htmlspecialchars($_SESSION['nome']) : ''; unset($_SESSION['nome']); ?>" required>

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

                            <!-- ####################################### -->
                            <!-- [INIZIO NUOVO ELEMENTO]                 -->
                            <!-- Verifica presenza zone nel database -->

                            <?php
                                // L'errore viene settato all'inizio del caricamento della pagina.
                                // Il codice di riferimento è possibile visualizzarlo nello script php all'inizio di questa pagina.

                                // Se non ci sono Prodotti nel database stampo l'errore n.1.
                                // Altrimenti procedo a stamparle...
                                if ( isset($total_records_error_msg) )
                                {
                                    echo '<p class="error-container error">'. htmlspecialchars($total_records_error_msg) . '</p>';
                                }
                                else
                                {
                                    // Includo il file che stampa "Risultati Trovati: X", e che permette di stampare i records selezionati.
                                    require_once ($module_selectprint);
                            ?>

                            <!-- ######################################### -->
                            <!-- [INIZIO NUOVO ELEMENTO]                   -->
                            <!-- Inizio codice per la tabella delle zone   -->

                                <table class="recap-table">
                                    <caption>Recap Zone</caption>
                                    <thead>
                                        <tr>
                                            <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="checkboxForm">
                                                <input type="hidden" name="order" id="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : 'ASC'; ?>">
                                                <input type="hidden" name="sort_by" id="sort_by" value="<?php echo isset($_GET['sort_by']) ? $_GET['sort_by'] : ''; ?>">
                                                <th scope="col" class="checkbox">
                                                    <span>Seleziona Tutti</span> <input type="checkbox" id="select-all" title="Seleziona tutte le righe per la Stampa">
                                                </th>
                                                <th scope="col">
                                                    <button type="button" title="Ordina per Nome Zona" onclick="updateOrder('zona_nome')">
                                                        <span>Nome Zona</span>
                                                        <i class="bi bi-chevron-expand"></i>
                                                    </button>
                                                </th>
                                                <th scope="col">
                                                    <button type="button" title="Ordina per Totale Famiglie della Zona" onclick="updateOrder('zona_totale_famiglie')">
                                                        <span>Totale Famiglie</span>
                                                        <i class="bi bi-chevron-expand"></i>
                                                    </button>
                                                </th>
                                                <th scope="col">
                                                    <button type="button" title="Ordina per Totale Famiglie della Zona" onclick="updateOrder('zona_somma_componenti_totali')">
                                                        <span>Componenti Totali</span>
                                                        <i class="bi bi-chevron-expand"></i>
                                                    </button>
                                                </th>
                                                <th scope="col">
                                                    <button type="button" title="Ordina per Totale Famiglie della Zona" onclick="updateOrder('zona_somma_componenti_minorenni')">
                                                        <span>Componenti Minorenni</span>
                                                        <i class="bi bi-chevron-expand"></i>
                                                    </button>
                                                </th>

                                                <th scope="col" class="actions"></th>
                                            </form>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            
                                    <?php
                                        foreach ($zone as $zona)
                                        {
                                            // Link per il dettaglio della zona
                                            $link = $link_dettaglio."?tipo=zona&id=".$zona->getId();
                                    ?>

                                    <tr>
                                        <td data-label="Seleziona Per Stampa">
                                            <input  type="checkbox" class="item-checkbox" data-content="Elemento" title="Seleziona per la Stampa"> 
                                        </td>

                                        <td data-label="Nome Zona">                 <?= htmlspecialchars ($zona -> getNome());                     ?> </td>
                                        <td data-label="Numero Famiglie">           <?= htmlspecialchars ($zona -> getNumeroFamiglie());           ?> </td>
                                        <td data-label="Somma Componenti Totali">   <?= htmlspecialchars ($zona -> getSommaComponentiTotali());    ?> </td>
                                        <td data-label="Somma Componenti < 16">     <?= htmlspecialchars ($zona -> getSommaComponentiMinorenni()); ?> </td>
                                        <td>
                                            <a href="<?= $link; ?>" title="Visualizza Dettagli">
                                                <i class="bi bi-arrow-right-square"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <?php 
                                        } 
                                    ?>

                                    </tbody>
                                </table>

                            <?php
                                } // Else
                            ?>

                    </div> <!-- col-dx-container -->
                </div> <!-- col-dx | main-content -->
            </div> <!-- row -->
        </div> <!-- container -->
    </main>
    
    <?php require_once ($module_scripts); ?>
</body>
</html>