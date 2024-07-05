/*
    Questo codice viene utilizzato dal modulo "sort_by.php".

    La funzione non fa altro che ottenere il metodo di ordinamento ed il metodo dell'ordine (ASC o DESC)
    prendendolo dal form contenuto nel thead delle tabelle contenute nel gestionale.

    Invio poi il form. Da questo punto in poi se ne occuperà lo script contenuto nelle rispettive pagine, es: zone, prodotti, etc...
*/

function updateOrder(sortByValue) 
{
    var orderField = document.getElementById('order');
    var sortByField = document.getElementById('sort_by');
    var currentOrder = orderField.value;
    var newOrder = (currentOrder === 'ASC') ? 'DESC' : 'ASC';

    orderField.value = newOrder;
    sortByField.value = sortByValue;

    var form = document.getElementById('checkboxForm');
    form.submit();
}
