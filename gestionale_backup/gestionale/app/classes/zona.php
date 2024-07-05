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

        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS

        public function verificaEsistenzaZona (Zona $zona)
        {
            $nome = $zona->getNome();

            $database = new Database();
            $conn = $database->getConnection();

            $query = "SELECT COUNT(*) AS num_zone FROM zone WHERE nome = :nome;";
            $stmt  = $conn->prepare($query);

            $stmt -> bindParam(':nome', $nome);

            try
            {
                $stmt -> execute();
                $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rows['num_zone'] > 0) 
                {
                    return ['status' => false, 'message' => 'La zona inserita è già presente nel database'];
                } 
                else 
                {
                    return ['status' => true, 'message' => 'La zona non è presente nel database, puoi procedere all\'inserimento'];
                }
                
            } 
            catch (PDOException $e)
            {
                error_log ('Errore durante la verifica della Zona' . $e->getMessage(), 0);
                echo $e->getMessage();
                return ['status' => false, 'message' => 'errore durante la verifica della Zona'];
            } 
            finally 
            {
                $database->closeConnection();
            }
        }

        public function insertNewZona (Zona $zona)
        {
            $nome = $zona->getNome();

            $database = new Database();
            $conn = $database->getConnection();

            $query = "INSERT INTO zone (nome) VALUES (:nome);";
            $stmt = $conn->prepare($query);

            $stmt -> bindParam(':nome', $nome);

            try
            {
                $stmt -> execute();
                $id = $conn->lastInsertId();
                return ['status' => true, 'message' => 'Zona inserita con successo.', 'id' => $id];
            } 
            catch (PDOException $e) 
            {
                error_log ('Errore nell\'inserimento della Zona: ' . $e->getMessage(), 0);
                echo $e->getMessage();
                return ['status' => false, 'message' => 'errore durante l\'inserimento della Zona'];
            } 
            finally 
            {
                $database->closeConnection();
            }
        }

    }

?>