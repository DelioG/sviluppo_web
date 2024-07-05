/* Questo è il codice che gestisce la sidebar del gestionale. */

var body	       = document.body;
var colSx 	 	   = document.getElementById("sidebar");
var colDx 	 	   = document.getElementById("mainContent");
var sidebarOverlay = document.getElementById("sidebarOverlay");
var sidebarOpen    = document.getElementById("sidebarOpen");
var sidebarClose   = document.getElementById("sidebarClose");

// Nascondo il button per aprire la sidebar, e torno a mostrarla.
// Mostro poi l'overlay della sidebar.
function sideOpen()
{
    colSx.style.display 		 = "initial";
    sidebarOpen.style.display 	 = "none";
    sidebarOverlay.style.display = "block";
}

// Torno a mostrare il button per aprire la sidebar, e nascondo la sidebar.
// Nascondo poi l'overlay della sidebar.
function sideClose()
{
    colSx.style.display 		 = "none";
    sidebarOpen.style.display 	 = "initial";
    sidebarOverlay.style.display = "none";
}

// Avvio il metodo per ottenere la grandezza dello schermo a pagina appena caricata.
// Aggiornamento della grandezza dello schermo in occasione di eventi resize.
widthResizer();
window.addEventListener('resize', widthResizer)

// Funzione per il racciamento della grandezza dello schermo.
function widthResizer()
{
    var width = window.innerWidth;

    // Nascondo l'overlay quando viene eseguito il resize della finestra.
    sidebarOverlay.style.display = "none";

    // Se l'utente si trova su schermi piccoli, o su mobile...
    // 1 - Mostro il button per aprire la sidebar.
    // 2 - Setto lo stato della sidebar.
    // 3 - Regole varie riguardanti l'animazione di apertura della sidebar.
    if(width < 1400) // if(width < 767.98)
    {
        sidebarOpen.style.display 			 = "initial";
        colSx.style.display 				 = "none";
        colSx.style.position				 = "fixed";
        colSx.style.top						 = "0";
        colSx.style.left					 = "0"
        colSx.style.width                    = "20em"
        colSx.style.transitionProperty 		 = "all";
        colSx.style.transitionDuration 		 = "0.4s";
        colSx.style.transitionTimingFunction = "ease";
        colSx.style.animationName 			 = "sidebarAnimation";
        colSx.style.animationDuration 		 = "0.4s";

        colSx.style.boxShadow                = "none";
    }
    // Se l'utente si trova su schermi grandi, o desktop...
    // 1 - Nascondo il button per aprire la sidebar.
    // 2 - Resetto lo stato della sidebar.
    else
    {
        sidebarOpen.style.display 	= "none";
        colSx.style.display 		= "initial";
        colSx.style.position		= "initial";
        colSx.style.top				= "initial";
        colSx.style.left			= "initial"
        colSx.style.width           = "initial"
        colSx.style.boxShadow       = "3px 4px 3px #c0cbf3";
    }

}