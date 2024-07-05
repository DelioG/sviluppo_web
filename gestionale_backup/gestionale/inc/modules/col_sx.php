<!-- Overlay utilizzato quando si apre la sidebar (col-sx) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="sideClose()" title="Chiudi menu"></div>

<!-- Button per aprire la sidebar su dispositivi mobile -->
<button onclick="sideOpen()" class="bounce" id="sidebarOpen" title="Apri menu"> <i class="bi bi-arrow-bar-right"></i> </button>

<!-- Sidebar -->
<div class="col-sx" id="sidebar">
    <div class="col-sx-container">

        <div class="brand"> 
            <a href="<?= $link_index; ?>"> <?= $website_name; ?> </a>
        </div> <!-- brand -->

        <ul class="menu">
            <li>
                <form class="form-ricerca" method="GET" action="<?php echo $link_ricerca; ?>">
                    <input title="Cerca..." name="ricerca" type="text" placeholder="cerca zone, famiglie, etc..." required>
                </form> <!-- form -->
            </li>
            <li> <a href="<?= $link_home;          ?>" title="Torna alla Home"                 class="<?php echo basename($_SERVER['PHP_SELF']) == 'home.php'          ? 'active' : ''; ?>"> <i class="bi bi-house"></i>       Home          </a> </li>
            <li> <a href="<?= $link_zone;          ?>" title="Consulta tutte le Zone"          class="<?php echo basename($_SERVER['PHP_SELF']) == 'zone.php'          ? 'active' : ''; ?>"> <i class="bi bi-geo-alt"></i>     Zone          </a> </li>
            <li> <a href="<?= $link_famiglie;      ?>" title="Consulta tutte le Famiglie"      class="<?php echo basename($_SERVER['PHP_SELF']) == 'famiglie.php'      ? 'active' : ''; ?>"> <i class="bi bi-people"></i>      Famiglie      </a> </li>
            <li> <a href="<?= $link_referenti;     ?>" title="Consulta tutte i Referenti"      class="<?php echo basename($_SERVER['PHP_SELF']) == 'referenti.php'     ? 'active' : ''; ?>"> <i class="bi bi-file-person"></i> Referenti     </a> </li>
            <li> <a href="<?= $link_prodotti;      ?>" title="Consulta tutti i Prodotti"       class="<?php echo basename($_SERVER['PHP_SELF']) == 'prodotti.php'      ? 'active' : ''; ?>"> <i class="bi bi-egg"></i>         Prodotti      </a> </li>
            <li> <a href="<?= $link_distribuzioni; ?>" title="Consulta tutte le Distribuzioni" class="<?php echo basename($_SERVER['PHP_SELF']) == 'distribuzioni.php' ? 'active' : ''; ?>"> <i class="bi bi-cart"></i>        Distribuzioni </a> </li>
        </ul> <!-- menu -->

        <div class="other">
            <div class="contacts">
                <p>Hai qualche dubbio? <br> Vuoi segnalare un errore?</p>
                <a href="mailto:<?= $website_author_email; ?>" title="Invia e-mail a: <?= $website_author_email; ?>">
                   Contatta Supporto <i class="bi bi-envelope-at"></i>
                </a>
            </div> <!-- contacts -->
            <div class="bottom">
                <div class="version" title="Data Rilascio: 13/06/2024">
                    ver. 1.0.0
                </div> <!-- version -->
                <div class="user">
                    <div class="profile">
                        <a href="<?= $link_account; ?>" title="Dettagli Account">
                            <i class="bi bi-person"></i>
                        </a>
                    </div> <!-- profile -->
                    <div class="logout">
                        <a href="<?= $link_logout; ?>" title="Esci dall'account">
                            <i class="bi bi-door-closed"></i>
                        </a>
                    </div> <!-- logout -->
                </div> <!-- user -->
            </div> <!-- bottom -->
        </div> <!-- other -->

    </div> <!-- col-sx-container -->
</div> <!-- col-sx | sidebar -->