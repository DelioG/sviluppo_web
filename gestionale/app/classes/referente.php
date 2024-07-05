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


        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS

        public function insertNewReferente(Referente $referente)
        {
            $cellulare = $referente->getCellulare();
            $cognome   = $referente->getCognome();
            $nome      = $referente->getNome();

            $database  = new Database();
            $conn      = $database->getConnection();

            $query     = "INSERT INTO referenti (cellulare, cognome, nome) VALUES (:cellulare, :cognome, :nome);";
            $stmt      = $conn->prepare($query);

            $stmt     -> bindParam(':cellulare', $cellulare);
            $stmt     -> bindParam(':cognome',   $cognome  );
            $stmt     -> bindParam(':nome',      $nome     );

            try 
            {
                $stmt -> execute();
                $id    = $conn->lastInsertId();
                return ['status' => true, 'message' => 'Referente inserito con successo.', 'id' => $id];
            } 
            catch (PDOException $e) 
            {
                error_log ('Errore nell\'inserimento del Referente: ' . $e->getMessage(), 0);
                echo $e->getMessage();
                return ['status' => false, 'message' => 'errore durante l\'inserimento del Referente.'];
            } 
            finally 
            {
                $database->closeConnection();
            }
        }       

    }

?>