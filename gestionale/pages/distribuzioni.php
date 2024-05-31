<?php
    require_once ("../inc/variables.php");
    require_once ($functions);
    require_once ($db_connection);

    require_once($component_session_check);
    
    $page_name        = $title_distribuzioni;
    $page_description = $description_distribuzioni;
    $page_keywords    = $keywords_distribuzioni;

    // ######################################################################################## //
    // ######################################################################################## //
    
    $results    = getAllDistribuzioni($conn);
    
    if ($results == null)
    {
        $error_message = "Non sono presenti Distribuzioni nel database!";
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
                                        <button class="disabled-button" title="Ordina per Nome" name="sort_by" value="data_distribuzione">
                                            Data Distribuzione
                                        </button> 
                                    </th>
                                    <th class="actions"></th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($results as $distribuzione)
                                {
                                    $link = $link_dettaglio."?tipo=distribuzione&id=".$distribuzione->getId();
                            ?>

                                <tr>
                                    <td> <input  type="checkbox" class="item-checkbox" data-content="Elemento">                     </td>
                                    <td> <a href="<?= $link; ?>"> <?= convertiData($distribuzione->getDataDistribuzione()); ?> </a> </td>
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