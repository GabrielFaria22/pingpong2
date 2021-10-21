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

    //$query = $game->getFirstGame();
    
    $game->getFirstGame();

    //$game = json_decode(json_encode($query), FALSE);

    $scoreParams = $data->score;

    $score = explode(':', $scoreParams);
    $scorePlayerA = intval($score[0]);
    $scorePlayerB = intval($score[1]);

    if ($scorePlayerA >= 21 && $scorePlayerB <= ($scorePlayerA - 2) ){
        $message = "Player A wins";
    }else if ($scorePlayerB >= 21 && $scorePlayerA <= ($scorePlayerB - 2) ){
        $message = "Player B wins";
    }

    if (!empty($message)){

        $game->score_a = 0;
        $game->score_b = 0;
        $game->turn = 0;
        $game->shoots = 0;

        $game->update($jogo);

        echo $message;

        exit;

    }

    $game->turn = empty(intval($game->turn)) ? false : true;

    $game->score_a = $scorePlayerA;
    $game->score_b = $scorePlayerB;

    if (($game->score_a >= 20 && $game->score_b >= 20 && $game->shoots >= 1) || ($game->shoots >= 4)){

        $game->turn = !$game->turn;
        $game->shoots = 0;

    }else{

        $game->shoots = $game->shoots + 1;

    }

    $game->update($jogo);

    $player = $game->turn ? 'b' : 'a';

    echo "player " . $player;


    

    

