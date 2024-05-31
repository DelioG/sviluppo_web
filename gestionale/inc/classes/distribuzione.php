<?php

    class Distribuzione 
    {
        private $id;
        private $data_distribuzione;

        public function __construct ($id, $data_distribuzione) 
        {
            $this->id                 = $id;
            $this->data_distribuzione = $data_distribuzione;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GETTERS & SETTERS

        public function getId() 
        {
            return $this->id;
        }

        public function getDataDistribuzione() 
        {
            return $this->data_distribuzione;
        }

        public function setId($id) 
        {
            $this->id = $id;
        }

        public function setDataDistribuzione($data_distribuzione) 
        {
            $this->data_distribuzione = $data_distribuzione;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GET METHODS

        public static function getAllDistribuzioni ($conn)
        {
            $query =  $conn -> prepare ("SELECT * FROM distribuzioni");
            $query -> execute();
            $stmt  =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0 )
            {
                $distribuzioni = array();

                foreach ($stmt as $record)
                {
                    $distribuzione = new Distribuzione ($record['id'], $record['data_distribuzione']);
                    array_push ($distribuzioni, $distribuzione);
                }

                return $distribuzioni;
            }
            else
            {
                return null;
            }
        }

        public static function getDistribuzioneById ($conn, $id)
        {
            $query  = $conn -> prepare ("SELECT * FROM distribuzioni WHERE id = :id LIMIT 1;");
			$query -> bindParam (':id', $id, PDO::PARAM_INT);
			$query -> execute();
			$stmt   = $query -> fetch(PDO::FETCH_ASSOC);

            if( $stmt && count($stmt) > 0 )
            {
                $distribuzione = new Distribuzione ($stmt['id'], $stmt['data_distribuzione']);
                return $distribuzione;
            }
            else
            {
                return null;
            }
        }

        public static function getDistribuzioneByDataDistribuzione ($conn, $data_distribuzione)
        {
            $data_distribuzione = "%".$data_distribuzione."%";
            $query  = $conn -> prepare ("SELECT * FROM distribuzioni WHERE data_distribuzione LIKE :data_distribuzione");
			$query -> bindParam (':data_distribuzione', $data_distribuzione, PDO::PARAM_INT);
			$query -> execute();
			$stmt   = $query -> fetch(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0  )
            {
                $distribuzioni = array();

                foreach ($stmt as $record)
                {
                    $distribuzione = new Distribuzione ($stmt['id'], $stmt['data_distribuzione']);
                    array_push ($distribuzioni, $distribuzione);
                }

                return $distribuzioni;
            }
            else
            {
                return null;
            }  
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS

        public static function ricercaDistribuzioni ($conn, $ricerca)
        {
            $risultati = array();

            $distribuzioni_by_datadistribuzione = Distribuzione::getDistribuzioneByDataDistribuzione ($conn, $ricerca);

            if ( $distribuzioni_by_datadistribuzione != null || $distribuzioni_by_datadistribuzione > 0 )
            {
                foreach ($distribuzioni_by_datadistribuzione as $record)
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