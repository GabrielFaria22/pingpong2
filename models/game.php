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
            $sqlQuery = "SELECT * FROM " . $this->dbTable . " WHERE id = 1";
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                $arrayObj = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];

                $this->id = $arrayObj['id'];
                $this->score_a = $arrayObj['score_a'];
                $this->score_b = $arrayObj['score_b'];
                $this->turn = $arrayObj['turn'];
                $this->shoots = $arrayObj['shoots'];

                return $arrayObj;
            }
            return $stmt;
        }

        public function update() {
            $sql = 'UPDATE game SET score_a = :score_a, score_b = :score_b, turn = :turn, shoots = :shoots WHERE id = :id';
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue('id', $this->id);
            $stmt->bindValue('score_a', $this->score_a);
            $stmt->bindValue('score_b', $this->score_b);
            $stmt->bindValue('turn', $this->turn);
            $stmt->bindValue('shoots', $this->shoots);
        
            $stmt->execute();
        }

        public function createGame()
        {     
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

