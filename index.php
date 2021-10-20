<?php

try{

    $connection = new PDO("mysql:host=172.17.0.4; dbname=pong", "root", "Raposa@2");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    


}catch(PDOException $e){
    throw new Exception('error connecting to the db.');
}

function actionSet()
{
    
}