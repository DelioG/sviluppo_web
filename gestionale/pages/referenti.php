<?php
    require_once ("../inc/variables.php");
    require_once ($functions);
    require_once ($db_connection);

    require_once($component_session_check);
    
    $page_name        = $title_referenti;
    $page_description = $description_referenti;
    $page_keywords    = $keywords_referenti;

    // ######################################################################################## //
    // ######################################################################################## //

    $results        = getAllReferenti($conn);

    if ($results == null)
    {
        $error_message = "Non sono presenti Referenti nel database!";
    }

    if ( isset($_GET['sort_by']) ) 
    {
			
		$sort_type 	= $_GET['sort_by'];
			
		switch ($sort_type)
		{

			case 'cognome':
				$results = ordinamentoPerCognome ($results);
				break;

            case 'nome':
                $results = ordinamentoPerNome ($results);
                break;
            
			case 'cellulare':
                $results = ordinamentoPerCellulare ($results);
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
                                        <button title="Ordina per Cognome" name="sort_by" value="cognome">
                                            Cognome   <i class="bi bi-chevron-expand"></i>
                                        </button>   
                                    </th>
                                    <th> 
                                        <button title="Ordina per Nome" name="sort_by" value="nome">
                                            Nome <i class="bi bi-chevron-expand"></i>
                                        </button> 
                                    </th>
                                    <th> 
                                        <button title="Ordina per Cellulare" name="sort_by" value="cellulare">
                                            Cellulare <i class="bi bi-chevron-expand"></i>
                                        </button> 
                                    </th>
                                    <th class="actions"></th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($results as $referente)
                            {
                                $link = $link_dettaglio."?tipo=referente&id=".$referente->getId();
                            ?>

                            <tr>
                                <td> <input  type="checkbox" class="item-checkbox" data-content="Elemento">             </td>
                                <td> <a href="<?= $link; ?>"> <?= $referente->getCognome();   ?>                   </a> </td>
                                <td> <a href="<?= $link; ?>"> <?= $referente->getNome(); ?>                        </a> </td>
                                <td> <a href="<?= $link; ?>"> <?= splitCellulare( $referente->getCellulare() ); ?> </a> </td>
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
                </div> <!-- recap-table (table-container) -->

                <?php
                }
                ?>

            </div> <!-- container -->
        </div> <!-- col-dx -->
    </div> <!-- row -->

    <?php require_once($component_scripts); ?>
</body>
</html>