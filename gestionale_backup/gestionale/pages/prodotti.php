<?php

    session_start();

    // Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("../inc/common_variables.php");
    require_once ($module_commonrequires);

    // Il title, la description e le keywords sono contenute nel file "inc/common_variables.php".
    $page_name        = $title_prodotti;
    $page_description = $description_prodotti;
    $page_keywords    = $keywords_prodotti;
    
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
    $total_records = $controller -> getAllProdotti();

    // Assegnazione effettuata per ritorane il numero di records trovati al "select_print.php".
    $records_found = $total_records["prodotti"];
    // Assegnazione effettuata semplicemente per migliorare la leggibilità del codice su questa pagina.
    $prodotti = $records_found;

    // Se non ci sono Prodotti nel database, credo un messaggio d'errore...
    if ( $prodotti == null )
    {
        $total_records_error_msg = "Non sono presenti Prodotti nel database!";
    }

    /* ########################################################################### */
    /* INSERIMENTO NUOVO PRODOTTO - [RICHIESTA POST]                               */
    /* ########################################################################### */

    // Codice eseguito quando l'utente inserisce un nuovo record
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $result_msg = $controller -> insertNewProdotto($_POST["produttore"], $_POST["nome"], $_POST["lotto"], $_POST["quantita"], $_POST["data_scadenza"]);

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

            case 'prodotto_produttore':
                $prodotti = Controller::ordinamentoAlfabetico ($records_found, $order, null, "getProduttore");
                break;

            case 'prodotto_nome':
                $prodotti = Controller::ordinamentoAlfabetico ($records_found, $order, null, "getNome");
                break;

            case 'prodotto_lotto':
                $prodotti = Controller::ordinamentoAlfabetico ($records_found, $order, null, "getLotto");
                break;

            case 'prodotto_quantita':
                $prodotti = Controller::ordinamentoNumerico ($records_found, $order, null, "getQuantita");
                break;

            case 'prodotto_datascadenza':
                $prodotti = Controller::ordinamentoAlfabetico ($records_found, $order, null, "getDataScadenza");
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
                        <!-- Inserimento nuovo Prodotto              -->

                        <div class="container-create-new">
                            <div class="tutorial">
                                <p> <i title="Breve Introduzione" class="bi bi-info-circle"></i> Perché inserire i Prodotti?</p>
                                <p>
                                    Dopo aver inserito i prodotti nel database, è possibile associarli alle diverse distribuzioni effettuate.
                                    <br><br>
                                    Quindi, l'inserimento dei prodotti è essenziale per monitorare quali prodotti sono stati distribuiti agli utenti durante ciascuna distribuzione.
                                </p>
                            </div>
                            <div class="create-new">
                                <p class="create-new-heading">Dettagli Prodotto</p>
                                <form method="POST" action="">

                                    <label>Nome Produttore del Prodotto: </label>
                                    <input type="text" name="produttore" placeholder="Inserisci il nome del produttore del prodotto..." maxlength="30" required>

                                    <label>Nome Prodotto: </label>
                                    <input type="text" name="nome" placeholder="Inserisci il nome del prodotto..." maxlength="30" required>
                                    
                                    <label>Lotto Prodotto: </label>
                                    <input type="text" name="lotto" placeholder="Inserisci il lotto del prodotto..." maxlength="30" required>

                                    <label>Quantità (in pezzi): </label>
                                    <input type="number" name="quantita" placeholder="Inserisci la quantità del prodotto disponibile..." min="0" required>

                                    <label>Data Scadenza: </label>
                                    <input type="date" name="data_scadenza" required>

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
                                        Inserisci Prodotto
                                    </button>

                                </form>
                            </div> <!-- -->
                        </div> <!-- container-createnew -->
                        
                        <hr>
                        
                        <!-- ####################################### -->
                        <!-- [INIZIO NUOVO ELEMENTO]                 -->
                        <!-- Verifica presenza prodotti nel database -->

                        <?php
                            // L'errore viene settato all'inizio del caricamento della pagina.
                            // Il codice di riferimento è possibile visualizzarlo nello script php all'inizio di questa pagina.

                            // Se non ci sono Prodotti nel database stampo l'errore n.1.
                            // Altrimenti procedo a stamparle...
                            if ( isset($total_records_error_msg) )
                            {
                                echo '<p class="error">'. htmlspecialchars($total_records_error_msg) . '</p>';
                            }
                            else
                            {
                                // Includo il file che stampa "Risultati Trovati: X", e che permette di stampare i records selezionati.
                                require_once ($module_selectprint);
                        ?>

                        <!-- ######################################### -->
                        <!-- [INIZIO NUOVO ELEMENTO]                   -->
                        <!-- Inizio codice per la tabella dei prodotti -->

                        <div class="table-container">
                            <table class="recap-table">
                                <caption>Recap Prodotto</caption>
                                <thead>
                                    <tr>
                                        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="checkboxForm">
                                            <input type="hidden" name="order" id="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : 'ASC'; ?>">
                                            <input type="hidden" name="sort_by" id="sort_by" value="<?php echo isset($_GET['sort_by']) ? $_GET['sort_by'] : ''; ?>">
                                            <th scope="col" class="checkbox">
                                                <span>Seleziona Tutti</span> <input type="checkbox" id="select-all" title="Seleziona tutte le righe per la Stampa">
                                            </th>
                                            <th scope="col">
                                                <button type="button" title="Ordina per Produttore" onclick="updateOrder('prodotto_produttore')">
                                                    <span>Produttore</span>
                                                    <i class="bi bi-chevron-expand"></i>
                                                </button>
                                            </th>
                                            <th scope="col">
                                                <button type="button" title="Ordina per Nome del Prodotto" onclick="updateOrder('prodotto_nome')">
                                                    <span>Nome Prodotto</span>
                                                    <i class="bi bi-chevron-expand"></i>
                                                </button>
                                            </th>
                                            <th scope="col">
                                                <button type="button" title="Ordina per Lotto del Prodotto" onclick="updateOrder('prodotto_lotto')">
                                                    <span>Lotto</span>
                                                    <i class="bi bi-chevron-expand"></i>
                                                </button>
                                            </th>
                                            <th scope="col">
                                                <button type="button" title="Ordina per Quantità disponibile del Prodotto" onclick="updateOrder('prodotto_quantita')">
                                                    <span>Quantità</span>
                                                    <i class="bi bi-chevron-expand"></i>
                                                </button>
                                            </th>
                                            <th scope="col">
                                                <button type="button" title="Ordina per Data di Scadenza del Prodotto" onclick="updateOrder('prodotto_datascadenza')">
                                                    <span>Data Scadenza</span>
                                                    <i class="bi bi-chevron-expand"></i>
                                                </button>
                                            </th>
                                            <th scope="col" class="actions"></th>
                                        </form>
                                    </tr>
                                </thead>
                                <tbody>
                                        
                                    <?php
                                        foreach ($prodotti as $prodotto)
                                        {
                                            $link = $link_dettaglio."?tipo=prodotto&id=".$prodotto->getId();
                                    ?>
                                    
                                    <tr>
                                        <td data-label="Seleziona Per Stampa">
                                            <input  type="checkbox" class="item-checkbox" data-content="Elemento" title="Seleziona per la Stampa"> 
                                        </td>

                                        <td data-label="Produttore">      <?= htmlspecialchars ($prodotto -> getProduttore());                                      ?> </td>
                                        <td data-label="Nome Produttore"> <?= htmlspecialchars ($prodotto -> getNome());                                            ?> </td>
                                        <td data-label="Lotto">           <?= htmlspecialchars ($prodotto -> getLotto());                                           ?> </td>
                                        <td data-label="Quantità">        <?= htmlspecialchars ($controller -> formattaNumero ( $prodotto -> getQuantita()     ) ); ?> </td>
                                        <td data-label="Data Scadenza">   <?= htmlspecialchars ($controller -> convertiData   ( $prodotto -> getDataScadenza() ) ); ?> </td>

                                        <td data-label="">
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
                        </div> <!-- table-container -->

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