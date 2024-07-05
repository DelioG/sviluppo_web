<?php

    class Database 
    {
        private $conn;
        private $db_type     = "mysql";
        private $db_server   = "127.0.0.1";
        private $db_name     = "gestionale";
        private $db_port     = "3306";
        private $db_charset  = "utf8mb4";
        private $db_username = "root";
        private $db_password = "";
        private $options     = 
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        public function __construct() 
        {
            $dsn = "{$this->db_type}:host={$this->db_server};port={$this->db_port};dbname={$this->db_name};charset={$this->db_charset}";

            try 
            {
                $this->conn = new PDO($dsn, $this->db_username, $this->db_password, $this->options);
            } 
            catch (PDOException $e) 
            {
                // error_log('Errore di connessione al database: ' . $e->getMessage(), 0);
                throw $e;
                return ['status' => false, 'message' => 'Errore di connessione al database'];
            }
        }

        public function getConnection() 
        {
            return $this->conn;
        }

        public function closeConnection() 
        {
            $this->conn = null;
        }

        public static function checkDatabaseConnection()
        {
            try
            {
                $database = new Database();
                $conn = $database->getConnection();
        
                $query = "SELECT 1;";
                $stmt  = $conn->prepare($query);
                $stmt -> execute();
        
                return true;
            }
            catch (PDOException $e)
            {
                // Log the error for debugging purposes
                // error_log('Errore durante il test di connessione al database: ' . $e->getMessage(), 0);
                throw $e;
            }
            finally
            {
                // Always ensure to close the connection if it was successfully opened
                if ($database) 
                {
                    $database->closeConnection();
                }
            }
        }
    }

    // Esempio di utilizzo della classe Database
    /*
        $database = new Database();
        $conn = $database->getConnection();

        // Utilizzare $conn per eseguire query o altre operazioni sul database

        // Quando non è più necessaria, chiudere la connessione
        $database->closeConnection();
    */
?>