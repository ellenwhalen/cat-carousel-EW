<?php
    session_start(); 
    include './config/config.php';
/* this allows you to save data in $_SESSION */
/* https://www.w3schools.com/php/php_sessions.asp */

/* write PHP functions here */

    function initializePage() {

        // $url = "http://api.thecatapi.com/v1/breeds?api_key=" . API_KEY;
        $url = "http://api.thecatapi.com/v1/breeds";
        $breedInfoRaw = file_get_contents($url);
        $breedInfo = json_decode($breedInfoRaw);
        $_SESSION["breedInfo"] = $breedInfo;
        // echo($breedInfo[0]->name);
        // echo(count($breedInfo));
        // echo($_SESSION["breedInfo"]);
        // for ($i=0; $i++; $i < count($breedInfo)) {
        // }
    }

    function initializeSelectForm() {
        $formHtml = '<form method="get" action="carousel.php"> <!-- action - when the user clicks, where to go?-->
            <select name="catID">';
        $breedInfo = $_SESSION["breedInfo"];
        for ($i=0; $i < count($breedInfo); $i++) {
            $thisName = $breedInfo[$i]->name;
            $formHtml .= '<option value="';
            $formHtml .= $thisName;
            $formHtml .= '">';
            $formHtml .= $thisName;
            $formHtml .= '</option>';
        }
        $formHtml .= '</select>
            <input type="submit" value="click here">
        </form>';
        echo($formHtml);
    }

?>

