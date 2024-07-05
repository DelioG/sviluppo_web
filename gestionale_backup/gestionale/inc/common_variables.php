<?php


    // INFORMAZIONI BASE DEL SITO.
    $website_name                    = "EasyOPT";
    $website_author                  = "Delio Graziano";
    $website_author_email            = "deliograziano35@gmail.com";
    $website_author_linkedin         = "deliograziano";

    // DATI UTILIZZATI NEI META-TAGS DELLE RISPETTIVE PAGINE.
    $title_index                     = "Index";
    $description_index               = "";
    $keywords_index                  = "";

    $title_home                      = "Home";
    $description_home                = "";
    $keywords_home                   = "";
    
    $title_zone                      = "Gestione Zone";
    $description_zone                = "";
    $keywords_zone                   = "";

    $title_famiglie                  = "Gestione Famiglie";
    $description_famiglie            = "";
    $keywords_famiglie               = "";

    $title_referenti                 = "Gestione Referenti";
    $description_referenti           = "";
    $keywords_referenti              = "";

    $title_prodotti                  = "Gestione Prodotti";
    $description_prodotti            = "";
    $keywords_prodotti               = "";

    $title_distribuzioni             = "Gestione Distribuzioni";
    $description_distribuzioni       = "";
    $keywords_distribuzioni          = "";

    $title_ricerca                   = "Ricerca";
    $description_ricerca             = "";
    $keywords_ricerca                = "";

    $title_dettaglio                 = "Dettaglio";
    $description_dettaglio           = "";
    $keywords_dettaglio              = "";

    $title_login                     = "Login";
    $description_login               = "";
    $keywords_login                  = "";

    $title_signup                    = "Registrazione";
    $description_signup              = "";
    $keywords_signup                 = "";

    $title_account                   = "Dettagli Account";
    $description_account             = "";
    $keywords_account                = "";

    $title_error                     = "Errore";
    $description_error               = "";
    $keywords_error                  = "";


    // LINK UTILIZZATI NEL MENU E NEL PATH.
    $root_path_website               = "/gestionale/";
    $link_index                      = $root_path_website."index.php";
    $link_home                       = $root_path_website."pages/home.php";
    $link_zone                       = $root_path_website."pages/zone.php";
    $link_famiglie                   = $root_path_website."pages/famiglie.php";
    $link_referenti                  = $root_path_website."pages/referenti.php";
    $link_prodotti                   = $root_path_website."pages/prodotti.php";
    $link_distribuzioni              = $root_path_website."pages/distribuzioni.php";
    $link_ricerca                    = $root_path_website."pages/ricerca.php";
    $link_account                    = $root_path_website."pages/account.php";
    $link_error                      = $root_path_website."pages/error.php";
    $link_dettaglio                  = $root_path_website."pages/dettaglio.php";

    $common_commonvariables          = dirname(__DIR__)."/inc/common_variables.php";
    $module_commonrequires           = dirname(__DIR__)."/inc/modules/common_requires.php";
    $module_headtags                 = dirname(__DIR__)."/inc/modules/head_tags.php";
    $module_colsx                    = dirname(__DIR__)."/inc/modules/col_sx.php";
    $module_scripts                  = dirname(__DIR__)."/inc/modules/scripts.php";
    $module_selectprint              = dirname(__DIR__)."/inc/modules/select_print.php";
    $module_sortby                   = dirname(__DIR__)."/inc/modules/sort_by.php";

    $app_controller                  = dirname(__DIR__)."/app/controller.php";

    $class_database                  = dirname(__DIR__)."/app/classes/database.php";
    $class_zona                      = dirname(__DIR__)."/app/classes/zona.php";
    $class_famiglia                  = dirname(__DIR__)."/app/classes/famiglia.php";
    $class_referente                 = dirname(__DIR__)."/app/classes/referente.php";
    $class_prodotto                  = dirname(__DIR__)."/app/classes/prodotto.php";
    $class_distribuzione             = dirname(__DIR__)."/app/classes/distribuzione.php";

    // LINKS PER IL RECUPERO DEI FILE DELLE FAVICON DEL SITO.
    // QUESTI FILE SONO CONTENUTI NEL FILE "HEAD-TAGS.PHP".
    $file_favicon_apple              = $root_path_website."img/favicon/apple-touch-icon.png";
    $file_favicon_32                 = $root_path_website."img/favicon/favicon-32x32.png";
    $file_favicon_16                 = $root_path_website."img/favicon/favicon-16x16.png";
    $file_favicon_manifest           = $root_path_website."img/favicon/site.webmanifest";

    // LINK PER I FILE CSS E DEI FILE JS DEL SITO.
    // IL CSS E' CONTENUTO NEL FILE "HEAD-TAGS.PHP", MENTRE INVECE, IL FILE JS DELLA SIDEBAR E' CONTENUTO NEL FOOTER DI OGNI PAGINA.
    $file_css_common                 = $root_path_website."css/common.css";
    $file_css_columSystem            = $root_path_website."css/column_system.css";
    $file_css_sidebar                = $root_path_website."css/sidebar.css";
    $file_css_main                   = $root_path_website."css/main.css";
    $file_css_table                  = $root_path_website."css/table.css";

    $file_js_sidebar                 = $root_path_website."js/sidebar.js";
    $file_js_order                   = $root_path_website."js/order.js";
    $file_js_print                   = $root_path_website."js/print.js";
?>