<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


    include '../config/database.php';
    include '../models/game.php';

    $database = new Database();
    $db = $database->getConnection();

    $game = new Game($db);

    $data = json_decode(file_get_contents("php://input"));

    $game->id = $data->id;

    if ($game->createGame()) {
        echo "game created";
    }else{
        echo "error on game creation";
    }
