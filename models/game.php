<?php
    class Game{

        private $connection;

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
            $sqlQuery = "SELECT * FROM " . $this->dbTable . "WHERE id = ?";
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            return $stmt;
        }

        public function getFirstGame()
        {
            $sqlQuery = "SELECT * FROM " . $this->dbTable . " WHERE id = ?";
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->bindParam(1, 1);
            $stmt->execute();
            var_dump($this->dbTable);
            exit;
            return $stmt;
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

