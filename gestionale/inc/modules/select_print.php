<!-- Questo file viene incluso in tutte le pagine delle tabelle -->
<div class="select-print">
    <div> 
        <p>
            Risultati Trovati: 
            <label>
                <?= count($records_found); ?>
            </label> 
        </p> 
    </div>
    <div>
        <button title="Stampa Tutti o Stampa Selezionati" onclick="stampaSelezionati()">
            <i class="bi bi-printer"></i>
        </button>       
    </div>
</div> <!-- results-found -->