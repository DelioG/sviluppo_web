<?php

    require_once ($common_commonvariables);
    require_once ($class_database);
    require_once ($class_zona);
    require_once ($class_famiglia);
    require_once ($class_referente);
    require_once ($class_prodotto);
    require_once ($class_distribuzione);

    class Controller
    {

        /* ################################################################## */
        /* VARIE                                                              */
        /* ################################################################## */

        public static function splitCellulare ($cellulare)
        {
            // Spiegazione: il numero di cellulare non ha una lunghezza fissa, ma cambia da paese a paese.
            // Il massimo della lunghezza che può raggiungere è di 15 caratteri, quindi faccio in modo da gestire tutte le occasioni possibili.
            // (anche se molto probabilmente i numeri di cellulare inseriti raggiungono "solo" le 10 cifre).

            // Limita la lunghezza massima della stringa a 15 caratteri.
            $cellulare = substr($cellulare, 0, 15);
            
            // Verifica che la stringa contenga solo cifre
            if (!ctype_digit($cellulare)) 
            {
                return "Formato cellulare non valido";
            }
            
            // Formatta il numero in base alla lunghezza
            if (strlen($cellulare) <= 10) 
            {
                $cellulare_splittato = substr($cellulare, 0, 3) . " " . substr($cellulare, 3, 3) . " " . substr($cellulare, 6, 4);
                $resto_cellulare     = substr($cellulare, 10);
            } 
            else 
            {
                $cellulare_splittato = substr($cellulare, 0, 3) . " " . substr($cellulare, 3, 3) . " " . substr($cellulare, 6, 4);
                $resto_cellulare     = substr($cellulare, 10);
            }
            
            return trim($cellulare_splittato . " " . $resto_cellulare);
        }

        public static function formattaNumero($numero)
        {
            if (!is_numeric($numero))
            {
                return "Numero non valido";
            }
            
            return number_format($numero, 0, ',', '.');
        }

        public static function convertiData ($data)
        {
            try 
            {
                $data = new DateTime($data);
                $dataFormattata = $data->format('d-m-Y');
                return $dataFormattata;
            } 
            catch (Exception $e) 
            {
                return "Data non valida";
            }
        }

        public static function ordinamentoNumerico (array $oggetti, string $order, ?string $object, string $getter): array
        {
            $orderFactor = $order === "DESC" ? -1 : 1;

            usort($oggetti, function($a, $b) use ($object, $getter, $orderFactor) 
            {
                $valueA = $object !== null ? $a->$object()->$getter() : $a->$getter();
                $valueB = $object !== null ? $b->$object()->$getter() : $b->$getter();

                return ($valueA <=> $valueB) * $orderFactor;
            });

            return $oggetti;
        }

        public static function ordinamentoAlfabetico (array $oggetti, string $order, ?string $object, string $getter): array
        {
            $orderFactor = $order === "DESC" ? -1 : 1;

            usort($oggetti, function($a, $b) use ($object, $getter, $orderFactor) 
            {
                $valueA = $object !== null ? $a->$object()->$getter() : $a->$getter();
                $valueB = $object !== null ? $b->$object()->$getter() : $b->$getter();

                return strcmp($valueA, $valueB) * $orderFactor;
            });

            return $oggetti;
        }
        
        /* ################################################################## */
        /* DATABASE                                                           */
        /* ################################################################## */

        public static function checkDatabaseConnection ()
        {
            return Database::checkDatabaseConnection();
        }

        /* ################################################################## */
        /* ZONE                                                               */
        /* ################################################################## */

        public function getAllZone ()
        {
            return Zona::getAllZone();
        }
        

        public function insertNewZona ($nome)
        {
            $nome = trim($nome);
        
            // Controllo se la stringa ha dei caratteri speciali al suo interno, e se rispettano la lunghezza minima e la lunghezza massima.
            if ( !preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' ]{1,30}$/", $nome) )
            {
                $status_msg = ['status' => false, 'message' => "Il nome della Zona può contenere solo lettere (a-z), spazi e l'apostrofo ('), con un massimo di 30 caratteri"];
            }
            else
            {
                // Sanificazione degli input dell'utente.
                $nome = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
        
                // Creo un oggetto con i dati passati dall'utente.
                $zona     = new Zona (null, $nome);
                $verifica = $zona->verificaEsistenzaZona($zona);

                // Verifico adesso se esiste già una zona con lo stesso nome.
                if ( !$verifica['status'] )
                {
                    $status_msg = ['status' => false, 'message' => "{$verifica['message']}"];
                }
                else
                {
                    // Avvio la funzione per inviare la query
                    $result   = $zona->insertNewZona($zona);
            
                    if ($result['status']) 
                    {
                        // Inserimento riuscito
                        $status_msg = ['status' => true, 'message' => "{$result['message']}"];
                    } 
                    else 
                    {
                        // Inserimento fallito
                        $status_msg = ['status' => false, 'message' => "{$result['message']}"];
                    }
                }

            }
        
            return $status_msg;
        }

        /* ################################################################## */
        /* FAMIGLIE                                                           */
        /* ################################################################## */

        public function insertNewFamiglia ($numero_fascicolo, $note, $componenti_minorenni, $componenti_totali)
        {
            $numero_fascicolo      = trim ( $numero_fascicolo      );
            $note                  = trim ( $note                  );
            $componenti_minorenni  = trim ( $componenti_minorenni  );
            $componenti_totali     = trim ( $componenti_totali     );
        
            // Controllo se la stringa ha dei caratteri speciali al suo interno, e se rispettano la lunghezza minima e la lugnhezza massima.
            if ( !preg_match("/^[0-9]+$/", $numero_fascicolo) ) 
            {
                $status_msg = ['status' => false, 'message' => "Il numero di fascicolo della famiglia deve contenere solo numeri (0-9), e deve avere un minimo di 10 caratteri ed un massimo di 15"];
            }
            else if ( !preg_match("/^[0-9]+$/", $componenti_minorenni) ) 
            {
                $status_msg = ['status' => false, 'message' => "Il campo Componenti Minorenni deve contenere solo numeri (0-9)"];
            }
            else if ( !preg_match("/^[0-9]+$/", $componenti_totali) ) 
            {
                $status_msg = ['status' => false, 'message' => "Il campo Componenti Totali deve contenere solo numeri (0-9)"];
            }
            // Controllo poi se i parametri passati dall'utente sono vuoti o meno.
            else if ( empty($numero_fascicolo) || empty($componenti_totali) )
            {
                $status_msg = ['status' => false, 'message' => "Per favore, verifica di aver riempito tutti i campi richiesti"];
            }
            else
            {
                // Sanificazione degli input dell'utente.
                $numero_fascicolo     = htmlspecialchars($numero_fascicolo,     ENT_QUOTES, 'UTF-8');
                $note                 = htmlspecialchars($note,                 ENT_QUOTES, 'UTF-8');
                $componenti_minorenni = htmlspecialchars($componenti_minorenni, ENT_QUOTES, 'UTF-8');
                $componenti_totali    = htmlspecialchars($componenti_totali,    ENT_QUOTES, 'UTF-8');

                // Avvio la funzione per inviare la query.
                $famiglia = new Famiglia (null, $numero_fascicolo, $note, $componenti_minorenni, $componenti_totali, null, null);
                $result   = $famiglia->verificaInserimentoFamiglia($famiglia);
                
                // Verifico adesso se esiste già un prodotto con lo stesso lotto.
                if ( !$result['status'] )
                {
                    $status_msg = ['status' => false, 'message' => "{$result['message']}"];
                }
                else
                {
                    // Avvio la funzione per inviare la query
                    $result   = $famiglia->insertNewFamiglia($famiglia);
                    
                    if ($result['status'])
                    {
                        // Inserimento riuscito
                        $status_msg = ['status' => true, 'message' => "{$result['message']}"];
                    }
                    else
                    {
                        // Inserimento fallito
                        $status_msg = ['status' => false, 'message' => "{$result['message']}"];
                    }
                }
            }
        
            return $status_msg;
        }

        /* ################################################################## */
        /* REFERENTI                                                          */
        /* ################################################################## */

        public function insertNewReferente($cellulare, $cognome, $nome)
        {
            $cellulare = trim( $cellulare );
            $cognome   = trim( $cognome   );
            $nome      = trim( $nome      );

            // Controllo se la stringa ha dei caratteri speciali al suo interno, e se rispettano la lunghezza minima e la lugnhezza massima.
            if ( !preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' ]{1,30}$/", $cognome) ) 
            {
                $status_msg = ['status' => false, 'message' => "Il cognome del referente può contenere solo lettere (a-z) e spazi, con un massimo di 30 caratteri"];
            }
            else if ( !preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' ]{1,30}$/", $nome) ) 
            {
                $status_msg = ['status' => false, 'message' => "Il nome del referente può contenere solo lettere (a-z) e spazi, con un massimo di 30 caratteri"];
            }
            else if ( !preg_match("/^\d{10,15}$/", $cellulare) ) 
            {
                $status_msg = ['status' => false, 'message' => "Il cellulare del referente deve contenere solo numeri (0-9), e deve avere un minimo di 10 caratteri ed un massimo di 15"];
            }
            // Controllo poi se i parametri passati dall'utente sono vuoti o meno.
            else if (empty($cognome) || empty($nome) || empty($cellulare)) 
            {
                $status_msg = ['status' => false, 'message' => "Per favore, verifica di aver riempito tutti i campi richiesti"];
            }
            else
            {
                // Sanificazione degli input dell'utente.
                $cellulare = htmlspecialchars($cellulare, ENT_QUOTES, 'UTF-8');
                $cognome   = htmlspecialchars($cognome,   ENT_QUOTES, 'UTF-8');
                $nome      = htmlspecialchars($nome,      ENT_QUOTES, 'UTF-8');

                // Avvio la funzione per inviare la query
                $referente = new Referente (null, $cellulare, $cognome, $nome);
                $result    = $referente->insertNewReferente($referente);

                if ($result['status']) 
                {
                    // Inserimento riuscito
                    $status_msg = ['status' => true, 'message' => "{$result['message']}"];
                }
                else 
                {
                    // Inserimento fallito
                    $status_msg = ['status' => false, 'message' => "{$result['message']}"];
                }
            }

            return $status_msg;
        }

        /* ################################################################## */
        /* PRODOTTI                                                           */
        /* ################################################################## */
        
        public function getAllProdotti ()
        {
            return Prodotto::getAllProdotti();
        }
        
        public function insertNewProdotto ($produttore, $nome, $lotto, $quantita, $data_scadenza)
        {
            $produttore     = trim($produttore);
            $nome           = trim($nome);
            $lotto          = trim($lotto);
        
            // Rimuovi tutti i punti e le virgole (se presenti) dalla quantità.
            $quantita       = trim($quantita);
            $quantita       = str_replace(array('.', ','), '', $quantita);
        
            // Controllo se la stringa ha dei caratteri speciali al suo interno, e se rispettano la lunghezza minima e la lunghezza massima.
            if (!preg_match("/^[A-Za-z0-9À-ÖØ-öø-ÿ\s.'()\-&]{1,30}$/u", $produttore) )
            {
                $status_msg = ['status' => false, 'message' => "Il nome del produttore può contenere solo caratteri alfabetici (a-z), caratteri numerici (0-9), il punto (.), l'apostrofo (') e la e commerciale (&), con un massimo di 30 caratteri"];
            }
            else if (!preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' ]{1,30}$/", $nome)) 
            {
                $status_msg = ['status' => false, 'message' => "Il nome del prodotto può contenere solo lettere (a-z), con un massimo di 30 caratteri"];
            }
            else if (!preg_match("/^[a-zA-Z0-9\-_]{1,30}$/", $lotto)) 
            {
                $status_msg = ['status' => false, 'message' => "Il lotto del prodotto può contenere solo caratteri alfabetici (a-z), caratteri numerici (0-9), il punto (.) e l'apostrofo ('), con un massimo di 30 caratteri"];
            }
            else if (!preg_match("/^[0-9]+$/", $quantita)) 
            {
                $status_msg = ['status' => false, 'message' => "La quantità disponibile del prodotto può contenere solo numeri (0-9), con un massimo di 11 caratteri"];
            }
            // Aggiorna l'espressione regolare per il formato YYYY-MM-DD
            else if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_scadenza)) 
            {
                $status_msg = ['status' => false, 'message' => "La data di scadenza non è valida"];
            }
            // Controllo la validità della data di scadenza, ovvero se non è antecedente a quella di oggi.
            else if (strtotime($data_scadenza) < strtotime(date('Y-m-d'))) 
            {
                $status_msg = ['status' => false, 'message' => "La data di scadenza non può essere antecedente a quella di oggi"];
            }
            // Controllo poi se i parametri passati dall'utente sono vuoti o meno.
            else if (empty($produttore) || empty($nome) || empty($lotto) || empty($quantita) || empty($data_scadenza)) 
            {
                $status_msg = ['status' => false, 'message' => "Per favore, verifica di aver riempito tutti i campi richiesti"];
            }
            else
            {
                // Sanificazione degli input dell'utente.
                $produttore    = htmlspecialchars($produttore,    ENT_QUOTES, 'UTF-8');
                $nome          = htmlspecialchars($nome,          ENT_QUOTES, 'UTF-8');
                $lotto         = htmlspecialchars($lotto,         ENT_QUOTES, 'UTF-8');
                $quantita      = htmlspecialchars($quantita,      ENT_QUOTES, 'UTF-8');
                $data_scadenza = htmlspecialchars($data_scadenza, ENT_QUOTES, 'UTF-8');
        
                // Creo un oggetto con i dati passati dall'utente.
                $prodotto = new Prodotto(null, $data_scadenza, $lotto, $nome, $quantita, $produttore);
                $verifica   = $prodotto->verificaInserimentoProdotto($prodotto);

                // Verifico adesso se esiste già un prodotto con lo stesso lotto.
                if ( !$verifica['status'] )
                {
                    $status_msg = ['status' => false, 'message' => "{$verifica['message']}"];
                }
                else
                {
                    // Avvio la funzione per inviare la query
                    $result   = $prodotto->insertNewProdotto($prodotto);
            
                    if ($result['status']) 
                    {
                        // Inserimento riuscito
                        $status_msg = ['status' => true, 'message' => "{$result['message']}"];
                    } 
                    else 
                    {
                        // Inserimento fallito
                        $status_msg = ['status' => false, 'message' => "{$result['message']}"];
                    }
                }

            }
        
            return $status_msg;
        }

        /* ################################################################## */
        /* DISTRIBUZIONI                                                      */
        /* ################################################################## */

        public function insertNewDistribuzione ($data_distribuzione)
        {
            $data_distribuzione = trim($data_distribuzione);
        
            // Aggiorna l'espressione regolare per il formato YYYY-MM-DD
            if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_distribuzione)) 
            {
                $status_msg = ['status' => false, 'message' => "La Data di Distribuzione non è valida"];
            }
            // Controllo la validità della data di scadenza, ovvero se non è antecedente a quella di oggi.
            else if (strtotime($data_distribuzione) < strtotime(date('Y-m-d'))) 
            {
                $status_msg = ['status' => false, 'message' => "La Data di Distribuzione non può essere antecedente a quella di oggi"];
            }
            // Controllo poi se i parametri passati dall'utente sono vuoti o meno.
            else if (empty($data_distribuzione)) 
            {
                $status_msg = ['status' => false, 'message' => "Per favore, verifica di aver riempito tutti i campi richiesti"];
            }
            else
            {
                // Sanificazione degli input dell'utente.
                $data_distribuzione = htmlspecialchars($data_distribuzione, ENT_QUOTES, 'UTF-8');
        
                // Creo un oggetto con i dati passati dall'utente.
                $distribuzione = new Distribuzione (null, $data_distribuzione);
                $result   = $distribuzione->insertNewDistribuzione($distribuzione);
            
                if ($result['status']) 
                {
                    // Inserimento riuscito
                    $status_msg = ['status' => true, 'message' => "{$result['message']}"];
                } 
                else 
                {
                    // Inserimento fallito
                    $status_msg = ['status' => false, 'message' => "{$result['message']}"];
                }
                
            }
        
            return $status_msg;
        }


    }

?>