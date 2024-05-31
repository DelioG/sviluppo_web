<?php
    require_once ("../inc/variables.php");
    require_once ($functions);
    require_once ($db_connection);

    require_once($component_session_check);

    $page_name        = $title_zone;
    $page_description = $description_zone;
    $page_keywords    = $keywords_zone;
    
    // ######################################################################################## //
    // ######################################################################################## //

    $results = getAllZone($conn);

    if ($results == null)
    {
        $error_message = "Non sono presenti Zone nel database!";
    }

    if ( $_SERVER["REQUEST_METHOD"] == "POST" )
    {
        $nome_nuova_zona = $_POST["nuova_zona"];
        creaNuovaZona($conn, $nome_nuova_zona);
        header("Refresh:0");
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
                
                <div class="create-new">
                    <p>Crea Nuova Zona</p>
                    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <input type="text" maxlength="30" id="createNewZona" name="nuova_zona" required>
                        <button title="Crea nuoa Zona">
                            <i class="bi bi-plus-square-dotted"></i>
                        </button>
                    </form>
                    <div class="remaining-chars">
                        <p>
                            Caratteri restanti: <label id="counter">30</label>  
                        </p>
                    </div>
                    <div class="famiglie-libere" id="famiglieLibere">
                        <div class="recap-table">
                            <table>
                                <thead>
                                    <tr>
                                        <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="checkboxForm">
                                            <th class="checkbox"> </th>
                                            <th class="dato-numerico">
                                                <button class="disabled-button" disabled>
                                                    n. fascicolo
                                                </button>
                                            </th>
                                            <th>
                                                <button class="disabled-button" disabled>
                                                    Cognome
                                                </button>
                                            </th>
                                            <th>
                                                <button class="disabled-button" disabled>
                                                   Nome
                                                </button> 
                                            </th>
                                        </form>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> <input  type="checkbox"> </td>
                                        <td> <a href="">341</a>       </td>
                                        <td> <a href="">Verdi</a>      </td>
                                        <td> <a href="">Paolo</a>       </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> <!-- recap-table -->
                    </div> <!-- famiglie-libere -->
                </div> <!-- create-new -->

                <hr>

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
                                        <button class="disabled-button" disabled>
                                            Nome
                                        </button> 
                                    </th>
                                    <th class="actions"></th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($results as $zona)
                                {
                            ?>
                                <!-- TODO: htmlspecialchars - ricordarsi di inserire questo codice -->
                                <tr>
                                    <td> <input  type="checkbox" class="item-checkbox" data-content="Elemento"> </td>
                                    <td> <a href="<?= $link_dettaglio."?tipo=zona&id=".$zona->getId(); ?>"> <?= $zona->getNome(); ?> </a>      </td>
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
    <script>
        // Questa sezione di codice conta quanti caratteri restano quando si crea una nuova zona.
        var textareaCreatePost    = document.getElementById('createNewZona');
        var counter               = document.getElementById('counter');
        textareaCreatePost.addEventListener('input', function()
        {
            // Limita la lunghezza del testo nel textarea a 255 caratteri
            if (textareaCreatePost.value.length > 30) 
            {
                textareaCreatePost.value = textareaCreatePost.value.slice(0, 30);
            }

            // Conta il numero di caratteri nel textarea
            var numeroCaratteri = textareaCreatePost.value.length;
                
            // Visualizza il numero di caratteri rimanenti nel div
            counter.textContent = (30 - numeroCaratteri);
        });

        // Se l'utente scrive il nome della zona da creare, compare un div contenente tutte
        // le famiglie libere che è possibile assegnare a quella determinata zona.
        document.getElementById('createNewZona').addEventListener('input', function() 
        {
            var inputValue = this.value;
            var hiddenDiv = document.getElementById('famiglieLibere');

            if (inputValue.trim() !== "") 
            {
                hiddenDiv.style.display = 'block';
            } else 
            {
                hiddenDiv.style.display = 'none';
            }
        });
    </script>
</body>
</html>
