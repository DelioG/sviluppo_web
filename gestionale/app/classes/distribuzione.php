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

        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS

        public function insertNewDistribuzione (Distribuzione $distribuzione)
        {
            $data_distribuzione = $distribuzione->getDataDistribuzione();

            $database = new Database();
            $conn = $database->getConnection();

            /* Iniziare a modificare a partire da qui */
            $query = "INSERT INTO distribuzioni (data_distribuzione) VALUES (:data_distribuzione);";
            $stmt  = $conn->prepare($query);

            $stmt -> bindParam(':data_distribuzione', $data_distribuzione);

            try
            {
                $stmt -> execute();
                $id = $conn->lastInsertId();
                return ['status' => true, 'message' => 'Distribuzione inserita con successo.', 'id' => $id];
            } 
            catch (PDOException $e) 
            {
                error_log ('Errore nell\'inserimento del Prodotto: ' . $e->getMessage(), 0);
                echo $e->getMessage();
                return ['status' => false, 'message' => 'errore durante l\'inserimento della Distribuzione.'];
            } 
            finally 
            {
                $database->closeConnection();
            }
        }

    }

?>