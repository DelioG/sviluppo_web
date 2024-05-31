<?php
    require_once ("../inc/variables.php");
    require_once ($functions);
    require_once ($db_connection);

    require_once($component_session_check);
    
    $page_name        = $title_famiglie;
    $page_description = $description_famiglie;
    $page_keywords    = $keywords_famiglie;

    // ######################################################################################## //
    // ######################################################################################## //
    
    $results         = getAllFamiglie($conn);

    if ($results == null)
    {
        $error_message = "Non sono presenti Famiglie nel database!";
    }

    if ( isset($_GET['sort_by']) ) 
    {
			
		$sort_type 	= $_GET['sort_by'];
			
		switch ($sort_type)
		{
			case 'numero_fascicolo':
                $results = ordinamentoPerNumeroFascicolo ($results);
				break;
            
			case 'note':
				$results = ordinamentoPerNote ($results);
				break;
            
			case 'componenti_totali':
                $results = ordinamentoPerComponentiTotali ($results);
				break;
            
            case 'componenti_minorenni':
				$results = ordinamentoPerComponentiMinorenni ($results);
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
                                    <th class="dato-numerico">
                                        <button title="Ordina per Numero Fascicolo" name="sort_by" value="numero_fascicolo">
                                            n. fascicolo <i class="bi bi-chevron-expand"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button title="Ordina per Note" name="sort_by" value="note">
                                            Note <i class="bi bi-chevron-expand"></i>
                                        </button>
                                    </th>
                                    <th class="dato-numerico">
                                        <button title="Ordina per Numero Componenti Totali" name="sort_by" value="componenti_totali">
                                            Comp. Totali <i class="bi bi-chevron-expand"></i>
                                        </button> 
                                    </th>
                                    <th class="dato-numerico"> 
                                        <button title="Ordina per Numero Componenti Minorenni" name="sort_by" value="componenti_minorenni">
                                            Comp. Minorenni <i class="bi bi-chevron-expand"></i>
                                        </button> 
                                    </th>
                                    <th class="actions"></th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($results as $famiglia)
                                {
                                    $link = $link_dettaglio."?tipo=famiglia&id=".$famiglia->getId();
                            ?>

                                <tr>
                                    <td> <input  type="checkbox" class="item-checkbox" data-content="Elemento">          </td>
                                    <td> <a href="<?= $link; ?>"> <?= $famiglia->getNumeroFascicolo(); ?>           </a> </td>
                                    <td> <a href="<?= $link; ?>"> <?= $famiglia->getNote(); ?>                      </a> </td>
                                    <td> <a href="<?= $link; ?>"> <?= $famiglia->getNumeroComponentiTotali(); ?>    </a> </td>
                                    <td> <a href="<?= $link; ?>"> <?= $famiglia->getNumeroComponentiMinorenni(); ?> </a> </td>
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