<?php

    class Famiglia 
    {
        private $id;
        private $numero_fascicolo;
        private $note;
        private $numero_componenti_totali;
        private $numero_componenti_minorenni;
        private $id_referente;
        private $id_zona;

        public function __construct ($id, $numero_fascicolo, $note, $numero_componenti_totali, $numero_componenti_minorenni, $referente, $zona) 
        {
            $this->id                          = $id;
            $this->numero_fascicolo            = $numero_fascicolo;
            $this->note                        = $note;
            $this->numero_componenti_totali    = $numero_componenti_totali;
            $this->numero_componenti_minorenni = $numero_componenti_minorenni;
            $this->referente                   = $referente;
            $this->zona                        = $zona;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GETTERS & SETTERS
        
        public function getId() 
        {
            return $this->id;
        }

        public function getNumeroFascicolo() 
        {
            return $this->numero_fascicolo;
        }

        public function getNote() 
        {
            return $this->note;
        }

        public function getNumeroComponentiTotali() 
        {
            return $this->numero_componenti_totali;
        }

        public function getNumeroComponentiMinorenni() 
        {
            return $this->numero_componenti_minorenni;
        }

        public function getReferente() 
        {
            return $this->referente;
        }

        public function getZona() 
        {
            return $this->zona;
        }

        /* SETTERS */
        
        public function setId($id) 
        {
            $this->id = $id;
        }

        public function setNumeroFascicolo($numero_fascicolo) 
        {
            $this->numero_fascicolo = $numero_fascicolo;
        }

        public function setNote($note) 
        {
            $this->note = $note;
        }

        public function setNumeroComponentiTotali($numero_componenti_totali) 
        {
            $this->numero_componenti_totali = $numero_componenti_totali;
        }

        public function setNumeroComponentiMinorenni($numero_componenti_minorenni) 
        {
            $this->numero_componenti_minorenni = $numero_componenti_minorenni;
        }

        public function setReferente($referente) 
        {
            $this->referente = $referente;
        }

        public function setZona($zona) 
        {
            $this->zona = $zona;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GET METHODS

        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS

        public function verificaInserimentoFamiglia (Famiglia $famiglia)
        {
            $numero_fascicolo = $famiglia->getNumeroFascicolo();

            $database = new Database();
            $conn = $database->getConnection();

            $query = "SELECT COUNT(*) AS num_famiglie FROM famiglie WHERE numero_fascicolo = :numero_fascicolo;";
            $stmt  = $conn->prepare($query);

            $stmt -> bindParam(':numero_fascicolo', $numero_fascicolo);

            try
            {
                $stmt -> execute();
                $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rows['num_famiglie'] > 0) 
                {
                    return ['status' => false, 'message' => "Il numero di fascicolo inserito è già presente nel database"];
                } 
                else 
                {
                    return ['status' => true, 'message' => 'Il numero di fascicolo non è presente nel database, puoi procedere all\'inserimento.'];
                }
                
            } 
            catch (PDOException $e)
            {
                error_log ('Errore durante la verifica del numero di fascicolo della famiglia' . $e->getMessage(), 0);
                echo $e->getMessage();
                return ['status' => false, 'message' => 'errore durante la verifica del numero di fascicolo della famiglia'];
            } 
            finally 
            {
                $database->closeConnection();
            }
        }

        public function insertNewFamiglia (Famiglia $famiglia)
        {
            $numero_fascicolo     = $famiglia->getNumeroFascicolo();
            $componenti_totali    = $famiglia->getNumeroComponentiTotali();
            $componenti_minorenni = $famiglia->getNumeroComponentiMinorenni();
            $note                 = $famiglia->getNote();

            $database = new Database();
            $conn = $database->getConnection();

            /* Iniziare a modificare a partire da qui */
            $query = "INSERT INTO famiglie (numero_fascicolo, num_componenti_totali, num_componenti_minorenni, note) VALUES (:numero_fascicolo, :num_componenti_totali, :num_componenti_minorenni, :note);";
            $stmt = $conn->prepare($query);

            $stmt -> bindParam(':numero_fascicolo',         $numero_fascicolo    );
            $stmt -> bindParam(':num_componenti_totali',    $componenti_totali   );
            $stmt -> bindParam(':num_componenti_minorenni', $componenti_minorenni);
            $stmt -> bindParam(':note',                     $note                );

            try
            {
                $stmt -> execute();
                $id = $conn->lastInsertId();
                return ['status' => true, 'message' => 'Famiglia inserita con successo.', 'id' => $id];
            } 
            catch (PDOException $e) 
            {
                error_log ('Errore nell\'inserimento del Prodotto: ' . $e->getMessage(), 0);
                echo $e->getMessage();
                return ['status' => false, 'message' => 'errore durante l\'inserimento della Famiglia.'];
            } 
            finally 
            {
                $database->closeConnection();
            }
        }

    }

?>
