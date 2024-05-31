<?php

    class Referente 
    {
        private $id;
        private $cellulare;
        private $cognome;
        private $nome;

        public function __construct ($id, $cellulare, $cognome, $nome) 
        {
            $this->id        = $id;
            $this->cellulare = $cellulare;
            $this->cognome   = $cognome;
            $this->nome      = $nome;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GETTERS & SETTERS

        public function getId() 
        {
            return $this->id;
        }

        public function getCellulare() 
        {
            return $this->cellulare;
        }

        public function getCognome() 
        {
            return $this->cognome;
        }

        public function getNome() 
        {
            return $this->nome;
        }

        public function setId($id) 
        {
            $this->id = $id;
        }

        public function setCellulare($cellulare) 
        {
            $this->cellulare = $cellulare;
        }

        public function setCognome($cognome) 
        {
            $this->cognome = $cognome;
        }

        public function setNome($nome) 
        {
            $this->nome = $nome;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GET METHODS

        public static function getAllReferenti ($conn)
        {
            $query      =  $conn -> prepare ("SELECT * FROM referenti");
            $query     ->  execute();
            $stmt  =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0 )
            {
                $referenti = array();

                foreach ($stmt as $record)
                {
                    $referente = new Referente ($record['id'], $record['cellulare'], $record['cognome'], $record['nome']);
                    array_push ($referenti, $referente);
                }

                return $referenti;
            }
            else
            {
                return null;
            }
        }

        public static function getReferenteById ($conn, $id)
        {
            $query_dettaglio  =  $conn -> prepare ("SELECT * FROM referenti WHERE id = :id LIMIT 1");
			$query_dettaglio ->  bindParam (':id', $id, PDO::PARAM_INT);
			$query_dettaglio ->  execute();
			$stmt_dettaglio   =  $query_dettaglio -> fetch(PDO::FETCH_ASSOC);

            if( $stmt_dettaglio > 0 )
            {
                $referente = new Referente ($stmt_dettaglio['id'], $stmt_dettaglio['cellulare'], $stmt_dettaglio['cognome'], $stmt_dettaglio['nome']);
                return $referente;
            }
            else
            {
                return null;
            }
        }

        public static function getReferenteByCellulare ($conn, $cellulare)
        {
            $query  =  $conn -> prepare ("SELECT * FROM referenti WHERE cellulare = :cellulare");
			$query ->  bindParam (':cellulare', $cellulare, PDO::PARAM_STR);
			$query ->  execute();
			$stmt   =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0  )
            {
                $referenti = array();

                foreach ($stmt as $record)
                {
                    $referente = new Referente ($record['id'], $record['cellulare'], $record['cognome'], $record['nome']);
                    array_push ($referenti, $referente);
                }

                return $referenti;
            }
            else
            {
                return null;
            }  
        }

        public static function getReferenteByCognome ($conn, $cognome)
        {
            $query  =  $conn -> prepare ("SELECT * FROM referenti WHERE cognome = :cognome");
			$query ->  bindParam (':cognome', $cognome, PDO::PARAM_STR);
			$query ->  execute();
			$stmt   =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0  )
            {
                $referenti = array();

                foreach ($stmt as $record)
                {
                    $referente = new Referente ($record['id'], $record['cellulare'], $record['cognome'], $record['nome']);
                    array_push ($referenti, $referente);
                }

                return $referenti;
            }
            else
            {
                return null;
            }  
        }

        public static function getReferenteByNome ($conn, $nome)
        {
            $query =  $conn -> prepare ("SELECT * FROM referenti WHERE nome = :nome");
			$query -> bindParam (':nome', $nome, PDO::PARAM_STR);
			$query -> execute();
			$stmt  =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0  )
            {
                $referenti = array();

                foreach ($stmt as $record)
                {
                    $referente = new Referente($record['id'], $record['cellulare'], $record['cognome'], $record['nome']);
                    array_push ($referenti, $referente);
                }

                return $referenti;
            }
            else
            {
                return null;
            }  
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS

        public static function ricercaReferenti ($conn, $ricerca)
        {
            $risultati = array();

            $referenti_by_cellulare = Referente::getReferenteByCellulare ($conn, $ricerca);
            $referenti_by_cognome   = Referente::getReferenteByCognome ($conn, $ricerca);
            $referenti_by_nome      = Referente::getReferenteByNome ($conn, $ricerca);
            
            if ( $referenti_by_cellulare && count($referenti_by_cellulare) > 0 )
            {
                foreach ($referenti_by_cellulare as $record)
                {
                    array_push($risultati, $record);
                }
            }
            
            if ( $referenti_by_cognome && count($referenti_by_cognome) > 0 )
            {
                foreach ($referenti_by_cognome as $record)
                {
                    array_push($risultati, $record);
                }
            }

            if ( $referenti_by_nome && count($referenti_by_nome) > 0)
            {
                foreach ($referenti_by_nome as $record)
                {
                    array_push($risultati, $record);
                }
            }

            if ( $risultati && count($risultati) > 0 )
            {
                return $risultati;
            }
            else
            {
                return null;
            }

        }
        
    }

?>