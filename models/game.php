<?php
    class Game{

        public $connection;

        public $dbTable = "game";

        public $id;
        public $score_a;
        public $score_b;
        public $turn;
        public $shoots;

        public function __construct($db)
        {
            $this->connection = $db;
        }

        public function getGame()
        {
            $sqlQuery = "SELECT * FROM " . $this->dbTable;
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        public function getSingleGame()
        {
            $sqlQuery = "SELECT * FROM " . $this->dbTable . " WHERE id = ?";
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            return $stmt;
        }

        public function getFirstGame()
        {
            global $pdo;
            $sqlQuery = "SELECT * FROM " . $this->dbTable . " WHERE id = 1";
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                $array = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $array[0];
            }
            return $stmt;
        }

        public function update($jogo) {
            $sql = 'UPDATE game SET score_a = :score_a, score_b = :score_b, turn = :turn, shoots = :shoots WHERE id = :id';
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue('id', $jogo['id']);
            $stmt->bindValue('score_a', $jogo['score_a']);
            $stmt->bindValue('score_b', $jogo['score_b']);
            $stmt->bindValue('turn', $jogo['turn']);
            $stmt->bindValue('shoots', $jogo['shoots']);
        
            $stmt->execute();
          }

        public function createGame()
        {
            //$sqlQuery = "INSERT INTO ". $this->dbTable ." VALUES :id";        
            $sqlQuery = "INSERT INTO " . $this->dbTable . "(id) VALUES(?)";
            $stmt = $this->connection->prepare($sqlQuery);
            $this->id=htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(1, $this->id);

            if ($stmt->execute()){
                return true;
            }
            return false;
        }
    }

