<?php

    // Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("../inc/common_variables.php");
    require_once ($module_commonrequires);

    // Il title, la description e le keywords sono contenute nel file "inc/common_variables.php".
    $page_name        = $title_error;
    $page_description = $description_error;
    $page_keywords    = $keywords_error;

    if (isset($_GET['error'])) 
    {
        // Decodifica il messaggio di errore
        $errorMessage = urldecode($_GET['error']);
    }

    // Risponde alla richiesta AJAX
    if (isset($_GET['check_db'])) 
    {
        echo Controller::checkDatabaseConnection() ? 'success' : 'error';
        exit;
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
                        
                        <?php echo '<p class="error-container error">'. htmlspecialchars($errorMessage) .'</p>'; ?>

                    </div> <!-- col-dx-container -->
                </div> <!-- col-dx | main-content --> 
            </div> <!-- row -->
        </div> <!-- container --> 
    </main>

    <?php require_once ($module_scripts); ?>
    <script>
        // Avvia il controllo quando la pagina è caricata
        window.onload = function() 
        {
            checkDatabase();
        };

        function checkDatabase() 
        {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?check_db=true', true);

            xhr.onload = function() 
            {
                if (xhr.status === 200) 
                {
                    if (xhr.responseText === 'success') 
                    {
                        window.location.href = '<?php echo $link_home; ?>';
                    } 
                    else 
                    {
                        setTimeout(checkDatabase, 5000);
                    }
                } 
                else 
                {
                    setTimeout(checkDatabase, 5000);
                }
            };

            xhr.onerror = function() 
            {
                setTimeout(checkDatabase, 5000);
            };

            xhr.send();
        }
    </script>
</body>
</html>
