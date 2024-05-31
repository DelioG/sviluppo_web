<?php
    require_once ("../inc/variables.php");
    require_once ($functions);
    require_once ($db_connection);

    require_once($component_session_check);
    
    $page_name        = $title_ricerca;
    $page_description = $description_ricerca;
    $page_keywords    = $keywords_ricerca;

    // ######################################################################################## //
    // ######################################################################################## //
    
    if ( isset ($_GET["ricerca"]) )
    {
        $ricerca           = $_GET["ricerca"];
        $risultati_ricerca = avviaRicerca($conn, $ricerca);

        if ($risultati_ricerca == null)
        {
            $error_message = "Nessun risultato trovato per [".$ricerca."]";
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
            
                <?php
                    if ( isset($error_message) )
                    {
                ?>
                    <p class="error-message"><?= $error_message; ?></p>
                <?php
                    }
                    else
                    {
                        ?>

                        <div class="results-found">

                        <?php
                        foreach($risultati_ricerca as $result)
                        {
                            if ($result instanceof Zona)
                            {
                                ?>
                                    <div class="result">
                                        <a href="<?= $link_dettaglio."?tipo=zona&id=".$result->getId(); ?>">
                                            <div class="tipologia">
                                                Zona
                                            </div>
                                            <div class="dettaglio numero-fascicolo">
                                                <?= $result->getNome(); ?>
                                            </div>
                                        </a>
                                    </div> <!-- result -->
                                <?php
                            }
                            else if ($result instanceof Famiglia)
                            {
                                ?>
                                    <div class="result">
                                        <a href="<?= $link_dettaglio."?tipo=famiglia&id=".$result->getId(); ?>">
                                            <div class="tipologia">
                                                Famiglia
                                            </div>
                                            <div class="dettaglio numero-fascicolo">
                                                <small>[Numero Fascicolo: <?= $result->getNumeroFascicolo(); ?>]</small>
                                            </div>
                                        </a>
                                    </div> <!-- result -->
                                <?php
                            }
                            else if ($result instanceof Referente)
                            {
                                ?>
                                    <div class="result">
                                        <a href="<?= $link_dettaglio."?tipo=referente&id=".$result->getId(); ?>">
                                            <div class="tipologia">
                                                Referente
                                            </div>
                                            <div class="dettaglio">
                                                <?= $result->getCognome(); ?> <?= $result->getNome(); ?>
                                            </div>
                                        </a>
                                        <div class="altri-dettagli">
                                            <small>[Cellulare: <?= splitCellulare($result->getCellulare()); ?>]</small>
                                        </div>
                                    </div> <!-- result -->
                                <?php
                            }
                            else if ($result instanceof Prodotto)
                            {
                                ?>
                                    <div class="result">
                                        <a href="<?= $link_dettaglio."?tipo=prodotto&id=".$result->getId(); ?>">
                                            <div class="tipologia">
                                                Prodotto
                                            </div>
                                            <div class="dettaglio">
                                                <?= $result->getNome(); ?>
                                            </div>
                                        </a>
                                        <div class="altri-dettagli">
                                            <small>[Lotto: <?= $result->getLotto(); ?>]</small>
                                            <br>
                                            <small>[Quantità: <?= $result->getQuantita(); ?>]</small>
                                            <br>
                                            <small>[Data Scadenza: <?= $result->getDataScadenza(); ?>]</small>
                                        </div>
                                    </div> <!-- result -->
                                <?php
                            }
                            else if ($result instanceof Distribuzione)
                            {
                                ?>
                                    <div class="result">
                                        <a href="<?= $link_dettaglio."?tipo=distribuzione&id=".$result->getId(); ?>">
                                            <div class="tipologia">
                                                Distribuzione
                                            </div>
                                            <div class="dettaglio">
                                                <?= $result->getDataDistribuzione(); ?>
                                            </div>
                                        </a>
                                        <div class="altri-dettagli">
                                            <small>[Totale Indigenti: 300]</small>
                                            <br><br>
                                            <small>[Totale Nuclei Continuativi: 34]</small>
                                            <br>
                                            <small>[Totale Nuclei Salutari: 3]</small>
                                            <br>
                                            <small>[Totale Nuclei: 37]</small>
                                        </div>
                                    </div> <!-- result -->
                                <?php
                            }
                        }
                        ?>

                        </div>

                        <?php
                    }
                ?>

            </div> <!-- container -->
        </div> <!-- col-dx -->
    </div> <!-- row -->

    <?php require_once($component_scripts); ?>
</body>
</html>