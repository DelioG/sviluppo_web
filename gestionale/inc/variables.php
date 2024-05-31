<?php
    // ##################################################################################################### //
    // ##################################################################################################### //
    
    // INFORMAZIONI BASE DEL SITO.
    $website_name               = "EasyOPT";
    $website_author             = "Delio Graziano";

    // DATI UTILIZZATI NEI META-TAGS DELLE RISPETTIVE PAGINE.
    $title_index                = "Index";
    $description_index          = "";
    $keywords_index             = "";

    $title_home                 = "Home";
    $description_home           = "";
    $keywords_home              = "";
    
    $title_zone                 = "Gestione Zone";
    $description_zone           = "";
    $keywords_zone              = "";

    $title_famiglie             = "Gestione Famiglie";
    $description_famiglie       = "";
    $keywords_famiglie          = "";

    $title_referenti            = "Gestione Referenti";
    $description_referenti      = "";
    $keywords_referenti         = "";

    $title_prodotti             = "Gestione Prodotti";
    $description_prodotti       = "";
    $keywords_prodotti          = "";

    $title_distribuzioni        = "Gestione Distribuzioni";
    $description_distribuzioni  = "";
    $keywords_distribuzioni     = "";

    $title_ricerca              = "Ricerca";
    $description_ricerca        = "";
    $keywords_ricerca           = "";

    $title_dettaglio            = "Dettaglio";
    $description_dettaglio      = "";
    $keywords_dettaglio         = "";

    $title_login                = "Login";
    $description_login          = "";
    $keywords_login             = "";

    $title_signup               = "Registrazione";
    $description_signup         = "";
    $keywords_signup            = "";

    // ##################################################################################################### //
    // ##################################################################################################### //
    
    // DATI UTILIZZATI PER LA CONNESSIONE AL DATABASE.
    // QUESTI DATI VENGONO UTILIZZATI NEL FILE "DB_CONNECTION.PHP".
    $db_type 	                = "mysql";
    $db_server                  = "127.0.0.1";
    $db_name 	                = "gestionale";
    $db_port 	                = "3306";
    $db_charset                 = "utf8mb4";
    $db_username                = "root";
    $db_password                = "";

    // ##################################################################################################### //
    // ##################################################################################################### //
    
    // LINK PER I REQUIRE_ONCE DEI MODULI CHE COMPONGONO IL SITO (GESTIONALE).

    $functions                  = dirname(__DIR__)."/inc/functions.php";
    $login_functions            = dirname(__DIR__)."/inc/login_system/login_functions.php";

    $db_connection              = dirname(__DIR__)."/inc/modules/db_connection.php";
    $component_head_tags        = dirname(__DIR__)."/inc/modules/head_tags.php";
    $component_navbar           = dirname(__DIR__)."/inc/modules/navbar.php";
    $component_col_sx           = dirname(__DIR__)."/inc/modules/col_sx.php";
    $component_path             = dirname(__DIR__)."/inc/modules/path.php";
    $component_scripts          = dirname(__DIR__)."/inc/modules/scripts.php";
    $component_results_print    = dirname(__DIR__)."/inc/modules/results_print.php";
    $component_session_check    = dirname(__DIR__)."/inc/login_system/session_check.php";

    $class_zona                 = dirname(__DIR__)."/inc/classes/zona.php";
    $class_famiglia             = dirname(__DIR__)."/inc/classes/famiglia.php";
    $class_referente            = dirname(__DIR__)."/inc/classes/referente.php";
    $class_distribuzione        = dirname(__DIR__)."/inc/classes/distribuzione.php";
    $class_prodotto             = dirname(__DIR__)."/inc/classes/prodotto.php";

    // ##################################################################################################### //
    // ##################################################################################################### //

    // LINK UTILIZZATI NEL MENU E NEL PATH.
    $root_path_website          = "/gestionale/";

    // ##################################################################################################### //
    // ##################################################################################################### //

    $link_index                 = $root_path_website."index.php";

    $link_home                  = $root_path_website."pages/home.php";
    $link_nuovo_elemento        = $root_path_website."pages/nuovo_elemento.php";
    $link_zone                  = $root_path_website."pages/zone.php";
    $link_famiglie              = $root_path_website."pages/famiglie.php";
    $link_referenti             = $root_path_website."pages/referenti.php";
    $link_prodotti              = $root_path_website."pages/prodotti.php";
    $link_distribuzioni         = $root_path_website."pages/distribuzioni.php";
    $link_ricerca               = $root_path_website."pages/ricerca.php";
    $link_dettaglio             = $root_path_website."pages/dettaglio.php";

    $link_logout                = $root_path_website."inc/login_system/logout.php";
    $link_login                 = $root_path_website."inc/login_system/login.php";
    $link_signup                = $root_path_website."inc/login_system/signup.php";
    $link_signup_confirmed      = $root_path_website."inc/login_system/signup_confirmed.php";

    // ##################################################################################################### //
    // ##################################################################################################### //

    // LINKS PER IL RECUPERO DEI FILE DELLE FAVICON DEL SITO.
    // QUESTI FILE SONO CONTENUTI NEL FILE "HEAD-TAGS.PHP".
    $file_favicon_apple         = $root_path_website."img/website_favicon/apple-touch-icon.png";
    $file_favicon_32            = $root_path_website."img/website_favicon/favicon-32x32.png";
    $file_favicon_16            = $root_path_website."img/website_favicon/favicon-16x16.png";
    $file_favicon_manifest      = $root_path_website."img/website_favicon/site.webmanifest";

    // LINK PER I FILE CSS E DEI FILE JS DEL SITO.
    // IL CSS E' CONTENUTO NEL FILE "HEAD-TAGS.PHP", MENTRE INVECE, IL FILE JS DELLA SIDEBAR E' CONTENUTO NEL FOOTER DI OGNI PAGINA.
    $file_css_common            = $root_path_website."css/common.css";
    $file_css_navbar            = $root_path_website."css/navbar.css";
    $file_css_sidebar           = $root_path_website."css/sidebar.css";
    $file_css_main              = $root_path_website."css/main.css";
    $file_css_column_system     = $root_path_website."css/column_system.css";
    $file_css_login_system      = $root_path_website."css/login_system.css";

    $file_js_sidebar            = $root_path_website."js/sidebar.js";
    $file_js_print              = $root_path_website."js/print.js";
    
?>