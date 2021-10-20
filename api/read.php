<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include '../config/database.php';
    include '../models/game.php';

    $database = new Database();
    $db = $database->getConnection();

    $games = new Game($db);

    $stmt = $games->getGame();
    $gameCount = $stmt->rowCount();

    echo json_encode($gameCount);

    if($gameCount > 0){

    $gameArr = array();
        $gameArr["body"] = array();
        $gameArr["itemCount"] = $gameCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id
            );

            array_push($gameArr["body"], $e);
        }
        echo json_encode($gameArr);
    }else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
