<?php

    class Zona 
    {

        private $id;
        private $nome;

        private $numero_famiglie;
        private $somma_componenti_totali;
        private $somma_componenti_minorenni;

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

        // Altro

        public function getNumeroFamiglie() 
        {
            return $this->numero_famiglie;
        }

        public function getSommaComponentiTotali() 
        {
            return $this->somma_componenti_totali;
        }

        public function getSommaComponentiMinorenni() 
        {
            return $this->somma_componenti_minorenni;
        }


        public function setNumeroFamiglie ($numeroFamiglie)
        {
            $this->numero_famiglie = $numeroFamiglie;
        }
    
        public function setSommaComponentiTotali ($sommaComponentiTotali)
        {
            $this->somma_componenti_totali = $sommaComponentiTotali;
        }
    
        public function setSommaComponentiMinorenni ($sommaComponentiMinorenni)
        {
            $this->somma_componenti_minorenni = $sommaComponentiMinorenni;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GET METHODS

        public static function getAllZone()
        {
            $database = new Database();
            $conn = $database->getConnection();

            $query = 
            "
                SELECT
                    z.id,
                    z.nome,
                    COUNT(f.id) AS numero_famiglie,
                    SUM(f.numero_componenti_totali) AS somma_componenti_totali,
                    SUM(f.numero_componenti_minorenni) AS somma_componenti_minorenni
                FROM
                    zone z
                LEFT JOIN
                    famiglie f ON z.id = f.id_zona
                GROUP BY
                    z.id, z.nome
            ";

            $stmt  = $conn->prepare($query);

            try 
            {
                $stmt->execute();
                $zoneArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $zone = [];
                
                foreach ($zoneArray as $zonaArray)
                {
                    $zona = new Zona($zonaArray['id'], $zonaArray['nome']);
                    $zona->setNumeroFamiglie($zonaArray['numero_famiglie']);
                    $zona->setSommaComponentiTotali($zonaArray['somma_componenti_totali']);
                    $zona->setSommaComponentiMinorenni($zonaArray['somma_componenti_minorenni']);
                    
                    $zone[] = $zona;
                }
                
                return ['status' => true, 'zone' => $zone];
            } 
            catch (PDOException $e) 
            {
                // Gestione dell'errore...
                return ['status' => false, 'message' => 'Errore durante l\'ottenimento delle Zone dal database'];
            } 
            finally
            {
                $database->closeConnection();
            }
        }


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