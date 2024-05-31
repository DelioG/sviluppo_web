<?php

    class Zona 
    {

        private $id;
        private $nome;

        public function __construct ($id, $nome) 
        {
            $this->id   = $id;
            $this->nome = $nome;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GETTERS & SETTERS

        public function getId () 
        {
            return $this->id;
        }

        public function getNome () 
        {
            return $this->nome;
        }

        public function setId ($id) 
        {
            $this->id = $id;
        }

        public function setNome ($nome) 
        {
            $this->nome = $nome;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GET METHODS
        
        public static function getAllZone ($conn)
        {
            $query  = $conn -> prepare ("SELECT * FROM zone");
            $query -> execute();
            $stmt   = $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0 )
            {
                $zone = array();

                foreach ( $stmt as $record )
                {
                    $zona = new Zona ($record['id'], $record['nome']);
                    array_push($zone, $zona);
                }

                return $zone;
            }
            else
            {
                return null;
            }
        }
        
        public static function getZonaById ($conn, $id)
        {
            $query  = $conn -> prepare ("SELECT * FROM zone WHERE id = :id LIMIT 1");
			$query -> bindParam (':id', $id, PDO::PARAM_INT);
			$query -> execute();
			$stmt   = $query -> fetch(PDO::FETCH_ASSOC);

            if( $stmt && count($stmt) > 0 )
            {
                $zona = new Zona ($stmt['id'], $stmt['nome']);
                return $zona;
            }
            else
            {
                return null;
            }
        }

        public static function getZonaByNome ($conn, $ricerca)
        {
            $query  =  $conn -> prepare ("SELECT * FROM zone WHERE nome = :ricerca");
			$query ->  bindParam (':ricerca', $ricerca, PDO::PARAM_STR);
			$query ->  execute();
			$stmt   =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt > 0 )
            {
                $zone = array();

                foreach ($stmt as $record)
                {
                    $zona = new Zona ($record['id'], $record['nome']);
                    array_push ($zone, $zona);
                }

                return $zone;
            }
            else
            {
                return null;
            }  
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS

        public static function ricercaZone ($conn, $ricerca)
        {
            $risultati = array();

            $zone_by_nome = Zona::getZonaByNome ($conn, $ricerca);

            if ( $zone_by_nome != null || $zone_by_nome > 0 )
            {
                foreach ($zone_by_nome as $record)
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
        
        public static function creaNuovaZona ($conn, $nome)
        {
			$query = $conn->prepare("INSERT INTO zone (nome) VALUES (:nome)");
			$query -> bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt  = $query->execute();
        }

    }

?>