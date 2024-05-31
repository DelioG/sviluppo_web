<?php

    class Prodotto 
    {
        private $id;
        private $data_scadenza;
        private $lotto;
        private $nome;
        private $quantita;

        public function __construct ($id, $data_scadenza, $lotto, $nome, $quantita) 
        {
            $this->id            = $id;
            $this->data_scadenza = $data_scadenza;
            $this->lotto         = $lotto;
            $this->nome          = $nome;
            $this->quantita      = $quantita;
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

        // ######################################################################################## //
        // ######################################################################################## //
        // GET METHODS

        public static function getAllProdotti ($conn)
        {
            $query     =  $conn -> prepare ("SELECT * FROM prodotti");
            $query     -> execute();
            $stmt  =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0 )
            {
                $prodotti = array();

                foreach ($stmt as $record)
                {
                    $prodotto = new Prodotto ($record['id'], $record['data_scadenza'], $record['lotto'], $record['nome'], $record['quantita']);
                    array_push ($prodotti, $prodotto);
                }

                return $prodotti;
            }
            else
            {
                return null;
            }
        }

        public static function getProdottoById ($conn, $id)
        {
            $query =  $conn -> prepare ("SELECT * FROM prodotti WHERE id = :id LIMIT 1;");
			$query -> bindParam (':id', $id, PDO::PARAM_INT);
			$query -> execute();
			$stmt  =  $query -> fetch(PDO::FETCH_ASSOC);

            if( $stmt && count($stmt) > 0 )
            {
                $prodotto = new Prodotto ($stmt['id'], $stmt['data_scadenza'], $stmt['lotto'], $stmt['nome'], $stmt['quantita']);
                return $prodotto;
            }
            else
            {
                return null;
            }
        }

        public static function getProdottoByDataScadenza ($conn, $data_scadenza)
        {
            $query =  $conn -> prepare ("SELECT * FROM prodotti WHERE data_scadenza = :data_scadenza");
			$query -> bindParam (':data_scadenza', $data_scadenza, PDO::PARAM_INT);
			$query -> execute();
			$stmt  =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0  )
            {
                $prodotti = array();

                foreach ($stmt as $record)
                {
                    $prodotto = new Prodotto ($record['id'], $record['data_scadenza'], $record['lotto'], $record['nome'], $record['quantita']);
                    array_push ($prodotti, $prodotto);
                }

                return $prodotti;
            }
            else
            {
                return null;
            } 
        }

        public static function getProdottoByLotto ($conn, $lotto)
        {
            $query =  $conn -> prepare ("SELECT * FROM prodotti WHERE lotto = :lotto");
			$query -> bindParam (':lotto', $lotto, PDO::PARAM_STR);
			$query -> execute();
			$stmt  =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0  )
            {
                $prodotti = array();

                foreach ($stmt as $record)
                {
                    $prodotto = new Prodotto ($record['id'], $record['data_scadenza'], $record['lotto'], $record['nome'], $record['quantita']);
                    array_push ($prodotti, $prodotto);
                }

                return $prodotti;
            }
            else
            {
                return null;
            } 
        }

        public static function getProdottoByNome ($conn, $nome)
        {
            $nome = "%".$nome."%";
            $query =  $conn -> prepare ("SELECT * FROM prodotti WHERE nome LIKE :nome");
			$query -> bindParam (':nome', $nome, PDO::PARAM_STR);
			$query -> execute();
			$stmt  =  $query -> fetchAll(PDO::FETCH_ASSOC);

            if ( $stmt && count($stmt) > 0  )
            {
                $prodotti = array();

                foreach ($stmt as $record)
                {
                    $prodotto = new Prodotto($record['id'], $record['data_scadenza'], $record['lotto'], $record['nome'], $record['quantita']);
                    array_push ($prodotti, $prodotto);  
                }

                return $prodotti;
            }
            else
            {
                return null;
            } 
        }

        // ######################################################################################## //
        // ######################################################################################## //
        // OTHER METHODS

        public static function ricercaProdotti ($conn, $ricerca)
        {
            $risultati = array();

            $prodotti_by_datascandeza = Prodotto::getProdottoByDataScadenza ($conn, $ricerca);
            $prodotti_by_lotto        = Prodotto::getProdottoByLotto ($conn, $ricerca);
            $prodotti_by_nome         = Prodotto::getProdottoByNome ($conn, $ricerca);

            if ( $prodotti_by_datascandeza && count($prodotti_by_datascandeza) > 0 )
            {
                foreach ($prodotti_by_datascandeza as $record)
                {
                    array_push($risultati, $record);
                }
            }
            
            if ( $prodotti_by_lotto && count($prodotti_by_lotto) > 0 )
            {
                foreach ($prodotti_by_lotto as $record)
                {
                    array_push($risultati, $record);
                }
            }

            if ( $prodotti_by_nome && count($prodotti_by_nome) > 0)
            {
                foreach ($prodotti_by_nome as $record)
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
