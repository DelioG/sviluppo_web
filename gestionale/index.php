<?php

    // Includo il file che contiene tutte le variabili con i path per la richiesta dei vari file da includere.
    require_once ("inc/common_variables.php");
    require_once ($module_commonrequires);

    // Il title, la description e le keywords sono contenute nel file "inc/common_variables.php".
    $page_name        = $title_index;
    $page_description = $description_index;
    $page_keywords    = $keywords_index;

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

                        <div class="welcome-user">
                            <div class="user-actions">
                                <div class="user-details">
                                    <div class="user-name">
                                        <p>Ciao, Utente</p>
                                    </div>
                                    <div class="last-log">
                                        <p>Penultimo accesso: 01/07/2024 - 11:58</p>
                                    </div>
                                </div>
                                <div class="actions">
                                    <button title="Modifica Username Utente"> <i class="bi bi-alphabet"></i>    <span> Modifica Username </span> </button>
                                    <button title="Modifica E-mail Utente">   <i class="bi bi-envelope-at"></i> <span> Modifica E-mail   </span> </button>
                                    <button title="Modifica Password Utente"> <i class="bi bi-pass"></i>        <span> Modifica Password </span> </button>
                                </div>
                                <div class="logout">
                                    <a href="">Esci</a>
                                </div>
                            </div>
                        </div> <!-- welcome-user -->

                    </div> <!-- col-dx-container -->
                </div> <!-- col-dx | main-content -->
            </div> <!-- row -->
        </div> <!-- container -->
    </main>
    
    <?php require_once ($module_scripts); ?>
</body>
</html>