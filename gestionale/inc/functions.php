<?php

    require_once ("variables.php");

	require_once ($class_zona);
	require_once ($class_famiglia);
	require_once ($class_referente);
	require_once ($class_distribuzione);
	require_once ($class_prodotto);

	// ##################################################################################################### //
    // ##################################################################################################### //

	// FUNZIONI VARIE

    function splitCellulare ($cellulare)
	{
		// Spiegazione: il numero di cellulare non ha una lunghezza fissa, ma cambia da paese a paese.
		// Il massimo della lunghezza che può raggiungere è di 15 caratteri, quindi faccio in modo da gestire tutte le occasioni possibili.
		// (anche se molto probabilmente i numeri di cellulare inseriti raggiungono "solo" le 10 cifre).

		// 1 - Limita la lunghezza massima della stringa a 15 caratteri.
		// 2 - Estrae i primi 10 caratteri suddivisi come desiderato.
		// 3 - Se invece è un numero che contiene più di 10 caratteri...
		// 4 - Estrae il resto della stringa per la stampa, se esiste.

		$cellulare 			 = substr($cellulare, 0, 15);
		$cellulare_splittato = substr($cellulare, 0, 3) . " " .  substr($cellulare, 3, 3) . " " . substr($cellulare, 6, 4);
		
		$resto_cellulare 	 = substr($cellulare, 10);
		return $cellulare_splittato . " " . $resto_cellulare;
	}

	function convertiData ($data)
	{
		$dataDistribuzione = $data;
		$data 			   = new DateTime($dataDistribuzione);
		$dataFormattata    = $data->format('d - m  - Y');
		
		return $dataFormattata;
	}

	function formattaNumero ($numero) 
	{
		$numero_formattato = number_format($numero, 0, ',', '.');
		return $numero_formattato;
	}

	// ##################################################################################################### //
    // ##################################################################################################### //

	// Funzioni per l'ottenimento dei dati dal database e dalle rispettive classi.

	function getAllZone ($conn)
	{
		return Zona::getAllZone ($conn);
	}

	function getAllReferenti ($conn)
	{
		return Referente::getAllReferenti ($conn);
	}

	function getAllFamiglie ($conn)
	{
		return Famiglia::getAllFamiglie ($conn);
	}

	function getAllProdotti ($conn)
	{
		return Prodotto::getAllProdotti ($conn);
	}

	function getAllDistribuzioni ($conn)
	{
		return Distribuzione::getAllDistribuzioni ($conn);
	}

	function getZonaById ($conn, $id)
	{
		return Zona::getZonaById ($conn, $id);
	}

	function getFamigliaById ($conn, $id)
	{
		return Famiglia::getFamigliaById ($conn, $id);
	}

	function getReferenteById ($conn, $id)
	{
		return Referente::getReferenteById ($conn, $id);
	}

	function getProdottoById ($conn, $id)
	{
		return Prodotto::getProdottoById ($conn, $id);
	}

	function getDistribuzioneById ($conn, $id)
	{
		return Distribuzione::getDistribuzioneById ($conn, $id);
	}

	// ##################################################################################################### //
    // ##################################################################################################### //

	// Funzione utilizzata quando viene avviata una ricerca. Viene effettuata una ricerca su tutte le tabelle presenti
	// sul database. I risultati vengono ottenuti richiamando le apposite funzioni di ricerca delle rispettive classi
	// I risultati vengono poi inseriti in un array di oggetti. L'array di oggetti verrà poi utilizzato nella pagina
	// di ricerca "ricerca.php".

	function avviaRicerca ($conn, $ricerca)
	{
		$risultatiRicerca = array();
		
		$zone 		   = Zona::ricercaZone ($conn, $ricerca);
		$famiglie      = Famiglia::ricercaFamiglie ($conn, $ricerca);
		$referenti     = Referente::ricercaReferenti ($conn, $ricerca);
		$prodotti 	   = Prodotto::ricercaProdotti ($conn, $ricerca);
		$distribuzioni = Distribuzione::ricercaDistribuzioni ($conn, $ricerca);

		// Estraggo tutti i risultati trovati, dai rispetti array, e li inserisco in un singolo array
		// di oggetti di varia tipologia: zona, famiglia, etc...

		if ( $zone && count($zone) > 0 )
		{
			foreach ($zone as $zona)
			{
				array_push($risultatiRicerca, $zona);
			}
		}

		if ( $famiglie && count($famiglie) > 0)
		{
			foreach ($famiglie as $famiglia)
			{
				array_push($risultatiRicerca, $famiglia);
			}
		}

		if ( $referenti && count($referenti) > 0 )
		{
			foreach ($referenti as $referente)
			{
				array_push($risultatiRicerca, $referente);
			}
		}

		if ( $prodotti && count($prodotti) > 0 )
		{
			foreach ($prodotti as $prodotto)
			{
				array_push($risultatiRicerca, $prodotto);
			}
		}

		if ( $distribuzioni && count($distribuzioni) > 0 )
		{
			foreach ($distribuzioni as $distribuzione)
			{
				array_push($risultatiRicerca, $distribuzione);
			}
		}

		// Controllo se non è stato trovato alcun risultato.
		
		if ($risultatiRicerca && count($risultatiRicerca) > 0 )
		{
			return $risultatiRicerca;
		}
		else
		{
			return null;
		}
	}

	function creaNuovaZona ($conn, $nome)
	{
		Zona::creaNuovaZona ($conn, $nome);
	}

    // ##################################################################################################### //
    // ##################################################################################################### //

    // Metodi generali per l'ordinamento degli array.

    function ordinamentoPerNome ($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return strcmp($a->getNome(), $b->getNome());
		});
		
		return $oggetti;
    }

	function ordinamentoPerCognome ($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return strcmp($a->getCognome(), $b->getCognome());
		});
		
		return $oggetti;
    }

	function ordinamentoPerCellulare ($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return strcmp($a->getCellulare(), $b->getCellulare());
		});
		
		return $oggetti;
    }

	function ordinamentoPerLotto ($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return strcmp($a->getLotto(), $b->getLotto());
		});
		
		return $oggetti;
    }

	function ordinamentoPerQuantita ($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return $a->getQuantita() - $b->getQuantita();
		});

		return $oggetti;
    }

	function ordinamentoPerData ($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return strcmp($a->getDataScadenza(), $b->getDataScadenza());
		});
		
		return $oggetti;
    }

	function ordinamentoPerNumeroFascicolo($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return $a->getNumeroFascicolo() - $b->getNumeroFascicolo();
		});

		return $oggetti;
    }

	function ordinamentoPerNote ($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return strcmp($b->getNote(), $a->getNote());
		});
		
		return $oggetti;
    }
	
	function ordinamentoPerComponentiTotali($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return $a->getNumeroComponentiTotali() - $b->getNumeroComponentiTotali();
		});

		return $oggetti;
    }

	function ordinamentoPerComponentiMinorenni($oggetti)
    {
        usort($oggetti, function($a, $b)
		{
			return $a->getNumeroComponentiMinorenni() - $b->getNumeroComponentiMinorenni();
		});

		return $oggetti;
    }

?>