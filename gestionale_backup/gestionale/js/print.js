/*
    Questo codice gestisce la stampa delle informazioni degli ogetti da stampare
    selezionati dagli utenti dalle varie tabelle del gestionale.
*/

document.getElementById('select-all').addEventListener('change', function() 
{
    const checkboxes = document.querySelectorAll('.item-checkbox');
    
    checkboxes.forEach
    (
        checkbox => 
        {
            checkbox.checked = this.checked;
        }
    );
});
function stampaSelezionati() 
{
    // Ottieni l'elemento <thead> della tabella
    const thead       = document.querySelector('.table-container thead');
    const clonedThead = thead.cloneNode(true);

    // Rimuovi l'ultima cella dall'elemento <thead> clonato
    const theadLastCell = clonedThead.querySelector('th:last-child');
    if (theadLastCell) theadLastCell.remove();

    // Ottieni tutti i checkbox selezionati
    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
    const printArea  = document.createElement('tbody');

    checkboxes.forEach
    (
        checkbox => 
        {
            // Ottieni la riga del checkbox selezionato
            const row = checkbox.closest('tr');

            if (row) 
            {
                const clonedRow = row.cloneNode(true);

                // Rimuovi l'ultima colonna dalla riga clonata
                const lastCell = clonedRow.querySelector('td:last-child');
                if (lastCell) lastCell.remove();

                printArea.appendChild(clonedRow);
            }
        }
    );

    // Stile CSS per la stampa, includendo l'orientamento orizzontale
    const style = 
    `
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');
            
            @page {
                size: landscape;
            }

            table 
            {
                font-family: "Quicksand", sans-serif;
                width: 100%;
                border-collapse: collapse;
            }

            th, td 
            {
                border: 1px solid #dddddd;
                padding: 5px;
                text-align: center;
            }

            th 
            {
                background-color: #2d53da;
                color: white;
            }

            tr:nth-child(even) 
            {
                background-color: #f2f5fd;
            }
            
            button
            {
                padding: 5px;
                display: block;
                width: 100%;

                background-color: #2d53da;
                color: white;
                border: 0;

                text-transform: uppercase;
                font-size: 0.75em;
                font-weight: 520;
                text-align: center;
            }

            a 
            {
                text-decoration: none;
                color: #212427;
            }
        </style>
    `;
            
    // Apri una nuova finestra per la stampa e inserisci il contenuto delle righe selezionate
    const printWindow = window.open('', '', 'height=768,width=1366');

    printWindow.document.write('<html><head><title>Stampa Selezionati</title>');

    // Includi lo stile CSS
    printWindow.document.write(style);

    printWindow.document.write('</head><body>');
    printWindow.document.write('<table>');

    printWindow.document.write(clonedThead.outerHTML); // Aggiungi l'elemento <thead> clonato
    printWindow.document.write(printArea.outerHTML);   // Aggiungi l'elemento <tbody> con le righe selezionate
    
    printWindow.document.write('</table>');
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.print();
}