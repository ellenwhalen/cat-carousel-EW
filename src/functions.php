<?php
    session_start(); 
    include './config/config.php';
/* this allows you to save data in $_SESSION */
/* https://www.w3schools.com/php/php_sessions.asp */

/* write PHP functions here */

    function initialize_page() {

        // $url = "http://api.thecatapi.com/v1/breeds?api_key=" . API_KEY;
        $url = "http://api.thecatapi.com/v1/breeds";
        $breedInfoRaw = file_get_contents($url);
        $breedInfo = json_decode($breedInfoRaw);
        echo($breedInfo[0]->name);
        echo(count($breedInfo));
        // for ($i=0; $i++; $i < count($breedInfo)) {

        // }
    }

?>

