<?php

    class Prodotto 
    {
        private $id;
        private $data_scadenza;
        private $lotto;
        private $nome;
        private $quantita;
        private $produttore;

        public function __construct ($id, $data_scadenza, $lotto, $nome, $quantita, $produttore) 
        {
            $this->id            = $id;
            $this->data_scadenza = $data_scadenza;
            $this->lotto         = $lotto;
            $this->nome          = $nome;
            $this->quantita      = $quantita;
            $this->produttore    = $produttore;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GETTERS & SETTERS
        
        public function getId() 
        {
            return $this->id;
        }

        public function getDataScadenza() 
        {
            return $this->data_scadenza;
        }

        public function getLotto() 
        {
            return $this->lotto;
        }

        public function getNome() 
        {
            return $this->nome;
        }

        public function getQuantita() 
        {
            return $this->quantita;
        }

        public function getProduttore() 
        {
            return $this->produttore;
        }

        public function setId($id) 
        {
            $this->id = $id;
        }

        public function setDataScadenza($data_scadenza) 
        {
            $this->data_scadenza = $data_scadenza;
        }

        public function setLotto($lotto) 
        {
            $this->lotto = $lotto;
        }

        public function setNome($nome) 
        {
            $this->nome = $nome;
        }

        public function setQuantita($quantita) 
        {
            $this->quantita = $quantita;
        }

        public function setProduttore($produttore)
        {
            $this->produttore = $produttore;
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // GET METHODS

        public static function getAllProdotti()
        {
            $database = new Database();
            $conn = $database->getConnection();

            $query = "SELECT * FROM prodotti ORDER BY nome;";
            $stmt  = $conn->prepare($query);

            try 
            {
                $stmt->execute();
                $prodottiArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $prodotti = [];
                
                foreach ($prodottiArray as $prodottoArray) 
                {
                    $prodotti[] = new Prodotto
                    (
                        $prodottoArray['id'],
                        $prodottoArray['data_scadenza'],
                        $prodottoArray['lotto'],
                        $prodottoArray['nome'],
                        $prodottoArray['quantita'],
                        $prodottoArray['produttore']
                    );
                }
                
                return ['status' => true, 'prodotti' => $prodotti];
            } 
            catch (PDOException $e) 
            {
                // error_log('Errore durante l\'ottenimento dei Prodotti dal database' . $e->getMessage(), 0);
                // echo $e->getMessage();
                return ['status' => false, 'message' => 'Errore durante l\'ottenimento dei Prodotti dal database'];
            } 
            finally
            {
                $database->closeConnection();
            }
        }


        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS

        public function verificaInserimentoProdotto (Prodotto $prodotto)
        {
            $data_scadenza = $prodotto->getDataScadenza();
            $lotto = $prodotto->getLotto();
            $produttore = $prodotto->getProduttore();

            $database = new Database();
            $conn = $database->getConnection();

            $query = "SELECT COUNT(*) AS num_prodotti FROM prodotti WHERE produttore = :produttore AND lotto = :lotto AND data_scadenza = :data_scadenza;";
            $stmt  = $conn->prepare($query);

            $stmt -> bindParam(':data_scadenza', $data_scadenza);
            $stmt -> bindParam(':lotto', $lotto);
            $stmt -> bindParam(':produttore',  $produttore);

            try
            {
                $stmt -> execute();
                $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rows['num_prodotti'] > 0) 
                {
                    return ['status' => false, 'message' => 'Il Prodotto inserito è già presente nel database. Se vuoi procedere, elimina prima il vecchio Prodotto e procedi poi al suo reinserimento.'];
                } 
                else 
                {
                    return ['status' => true, 'message' => 'Il Prodotto non è presente nel database, puoi procedere all\'inserimento.'];
                }
                
            } 
            catch (PDOException $e)
            {
                // error_log ('Errore durante la verifica del lotto del Prodotto' . $e->getMessage(), 0);
                // echo $e->getMessage();
                return ['status' => false, 'message' => 'errore durante la verifica del lotto del Prodotto'];
            } 
            finally 
            {
                $database->closeConnection();
            }
        }

        public function insertNewProdotto (Prodotto $prodotto)
        {
            $data_scadenza = $prodotto->getDataScadenza();
            $lotto = $prodotto->getLotto();
            $nome = $prodotto->getNome();
            $quantita = $prodotto->getQuantita();
            $produttore = $prodotto->getProduttore();

            $database = new Database();
            $conn = $database->getConnection();

            $query = "INSERT INTO prodotti (data_scadenza, lotto, nome, quantita, produttore) VALUES (:data_scadenza, :lotto, :nome, :quantita, :produttore);";
            $stmt = $conn->prepare($query);

            $stmt -> bindParam(':data_scadenza', $data_scadenza);
            $stmt -> bindParam(':lotto', $lotto);
            $stmt -> bindParam(':nome', $nome);
            $stmt -> bindParam(':quantita', $quantita);
            $stmt -> bindParam(':produttore', $produttore);

            try
            {
                $stmt -> execute();
                $id = $conn->lastInsertId();
                return ['status' => true, 'message' => 'Prodotto inserito con successo.', 'id' => $id];
            } 
            catch (PDOException $e) 
            {
                // error_log ('Errore nell\'inserimento del Prodotto: ' . $e->getMessage(), 0);
                // echo $e->getMessage();
                return ['status' => false, 'message' => 'errore durante l\'inserimento del Prodotto.'];
            } 
            finally 
            {
                $database->closeConnection();
            }
        }

    }

?>
