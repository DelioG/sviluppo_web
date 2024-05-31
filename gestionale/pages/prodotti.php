<?php
    require_once ("../inc/variables.php");
    require_once ($functions);
    require_once ($db_connection);

    require_once($component_session_check);
    
    $page_name        = $title_prodotti;
    $page_description = $description_prodotti;
    $page_keywords    = $keywords_prodotti;

    // ######################################################################################## //
    // ######################################################################################## //
    
    $results         = getAllProdotti($conn);

    if ($results == null)
    {
        $error_message = "Non sono presenti Prodotti nel database!";
    }

    if ( isset($_GET['sort_by']) ) 
    {
		$sort_type 	= $_GET['sort_by'];
			
		switch ($sort_type)
		{
			case 'nome':
                $results = ordinamentoPerNome ($results);
				break;
            
			case 'lotto':
				$results = ordinamentoPerLotto ($results);
				break;
            
			case 'quantita':
                $results = ordinamentoPerQuantita ($results);
				break;
            
            case 'data_scadenza':
				$results = ordinamentoPerData ($results);
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

                <?php require_once($component_results_print); ?>

                <div class="recap-table">
                    <table>
                        <thead>
                            <tr>
                                <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="checkboxForm">
                                    <th class="checkbox">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th> 
                                        <button title="Ordina per Nome" name="sort_by" value="nome">
                                            Nome   <i class="bi bi-chevron-expand"></i>
                                        </button>   
                                    </th>
                                    <th> 
                                        <button title="Ordina per Lotto" name="sort_by" value="lotto">
                                            Lotto <i class="bi bi-chevron-expand"></i>
                                        </button> 
                                    </th>
                                    <th class="dato-numerico"> 
                                        <button title="Ordina per Quantità" name="sort_by" value="quantita">
                                            Quantità <i class="bi bi-chevron-expand"></i>
                                        </button> 
                                    </th>
                                    <th> 
                                        <button title="Ordina per Data di Scadenza" name="sort_by" value="data_scadenza">
                                            Data di Scadenza <i class="bi bi-chevron-expand"></i>
                                        </button> 
                                    </th>
                                    <th class="actions"></th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($results as $prodotto)
                            {
                            $link = $link_dettaglio."?tipo=prodotto&id=".$prodotto->getId();
                            ?>
                                <tr> 
                                    <td> <input  type="checkbox" class="item-checkbox" data-content="Elemento">           </td>
                                    <td> <a href="<?= $link; ?>"> <?= $prodotto->getNome();         ?>               </a> </td>
                                    <td> <a href="<?= $link; ?>"> <?= $prodotto->getLotto();        ?>               </a> </td>
                                    <td> <a href="<?= $link; ?>"> <?= formattaNumero($prodotto->getQuantita()); ?>   </a> </td>
                                    <td> <a href="<?= $link; ?>"> <?= convertiData($prodotto->getDataScadenza()); ?> </a> </td>
                                    <td>
                                        <button title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button title="Elimina">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div> <!-- recap-table -->
                <?php
                }
                ?>
                
            </div> <!-- container -->
        </div> <!-- col-dx -->
    </div> <!-- row -->

    <?php require_once($component_scripts); ?>
</body>
</html>