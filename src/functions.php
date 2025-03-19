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
        $formHtml = '<div class="row">
            <div class="col-sm-7"><form method="get" action="carousel.php">
            <select name="catID" class="form-select">';
        $breedInfo = $_SESSION["breedInfo"];
        for ($i=0; $i < count($breedInfo); $i++) {
            $thisName = $breedInfo[$i]->name;
            $formHtml .= '<option value="' . $thisName . '">' . $thisName . '</option>';
        }
        $formHtml .= '</select>
            </div>
            <div class="col-sm-5">
            <input type="submit" value="See cats!" class="btn btn-primary">
            </div>
            </div>
            </form>';
        echo($formHtml);
    }

?>

