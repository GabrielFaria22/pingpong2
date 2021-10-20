<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


    include '../config/database.php';
    include '../models/game.php';

    $data = json_decode(file_get_contents("php://input"));

    $database = new Database();
    $db = $database->getConnection();

    $game = new Game($db);

    $game->id = $data->id;

    $game->getFirstGame();

    

    var_dump($game);
    exit;



    

    

