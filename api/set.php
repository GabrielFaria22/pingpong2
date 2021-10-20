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

    $game->getFirstGame();
    $jogo = $game->getFirstGame();

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

        $jogo['score_a'] = 0;
        $jogo['score_b'] = 0;
        $jogo['turn'] = 0;
        $jogo['shoots'] = 0;

        $game->update($jogo);

        echo $message;

        exit;

    }

    $jogo['turn'] = empty(intval($jogo['turn'])) ? false : true;

    $jogo['score_a'] = $scorePlayerA;
    $jogo['score_b'] = $scorePlayerB;

    if (($jogo['score_a'] >= 20 && $jogo['score_b'] >= 20 && $jogo['shoots'] >= 1) || ($jogo['shoots'] >= 4)){

        $jogo['turn'] = !$jogo['turn'];
        $jogo['shoots'] = 0;

    }else{

        $jogo['shoots'] = $jogo['shoots'] + 1;

    }

    /* $jogo['score_b'] = 20;
    $jogo['id'] = 2; */

    $game->update($jogo);

    $player = $jogo['turn'] ? 'b' : 'a';

    echo "player " . $player;


    

    

