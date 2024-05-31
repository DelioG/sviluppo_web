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

        public function __construct ($id, $numero_fascicolo, $note, $numero_componenti_totali, $numero_componenti_minorenni, $id_referente, $id_zona) 
        {
            $this->id                          = $id;
            $this->numero_fascicolo            = $numero_fascicolo;
            $this->note                        = $note;
            $this->numero_componenti_totali    = $numero_componenti_totali;
            $this->numero_componenti_minorenni = $numero_componenti_minorenni;
            $this->id_referente                = $id_referente;
            $this->id_zona                     = $id_zona;
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

        public function getIdReferente() 
        {
            return $this->id_referente;
        }

        public function getIdZona() 
        {
            return $this->id_zona;
        }

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

        public function setIdReferente($id_referente) 
        {
            $this->id_referente = $id_referente;
        }

        public function setIdZona($id_zona) 
        {
            $this->id_zona = $id_zona;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GET METHODS

        public static function getAllFamiglie ($conn)
        {
            $query  = $conn -> prepare("SELECT * FROM famiglie");
            $query -> execute();
            $stmt   = $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0 )
            {
                $famiglie = array();

                foreach ($stmt as $record)
                {
                    $famiglia = new Famiglia ($record['id'], $record['numero_fascicolo'], $record['note'], $record['numero_componenti_totali'], $record['numero_componenti_minorenni'], $record['id_referente'], $record['id_zona']);
                    array_push ($famiglie, $famiglia);
                }

                return $famiglie;
            }
            else
            {
                return null;
            }
        }

        public static function getFamigliaById ($conn, $id)
        {
            $query  = $conn -> prepare ("SELECT * FROM famiglie WHERE id = :id LIMIT 1;");
			$query -> bindParam (':id', $id, PDO::PARAM_INT);
			$query -> execute();
			$stmt   = $query -> fetch(PDO::FETCH_ASSOC);

            if( $stmt && count($stmt) > 0 )
            {
                $famiglia = new Famiglia ($stmt['id'], $stmt['numero_fascicolo'], $stmt['note'], $stmt['numero_componenti_totali'], $stmt['numero_componenti_minorenni'], $stmt['id_referente'], $stmt['id_zona']);
                return $famiglia;
            }
            else
            {
                return null;
            }
        }

        public static function getFamigliaByNumeroFascicolo ($conn, $numero_fascicolo)
        {
            $query  = $conn -> prepare ("SELECT * FROM famiglie WHERE numero_fascicolo = :numero_fascicolo");
			$query -> bindParam (':numero_fascicolo', $numero_fascicolo, PDO::PARAM_INT);
			$query -> execute();
			$stmt   = $query -> fetchAll(PDO::FETCH_ASSOC);

            if( $stmt && count($stmt) > 0 )
            {
                $famiglie = array();

                foreach ($stmt as $record)
                {
                    $famiglia = new Famiglia ($record['id'], $record['numero_fascicolo'], $record['note'], $record['numero_componenti_totali'], $record['numero_componenti_minorenni'], $record['id_referente'], $record['id_zona']);
                    array_push ($famiglie, $famiglia);
                }

                return $famiglie;
            }
            else
            {
                return null;
            }
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS
        
        public static function ricercaFamiglie ($conn, $ricerca)
        {
            $risultati = array();
            
            $famiglie_by_numerofascicolo = Famiglia::getFamigliaByNumeroFascicolo ($conn, $ricerca);

            if ( $famiglie_by_numerofascicolo != null || $famiglie_by_numerofascicolo > 0 )
            {
                foreach ($famiglie_by_numerofascicolo as $record)
                {
                    array_push($risultati, $record);
                }

                return $risultati;
            }
            else
            {
                return null;
            }
        }

    }

?>
