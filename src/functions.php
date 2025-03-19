<?php
    session_start(); 
    include './config/config.php';
/* this allows you to save data in $_SESSION */
/* https://www.w3schools.com/php/php_sessions.asp */

/* write PHP functions here */

    function initializePage() {
        $url = "http://api.thecatapi.com/v1/breeds";
        $breedInfoRaw = file_get_contents($url);
        $breedInfo = json_decode($breedInfoRaw);
        $_SESSION["breedInfo"] = $breedInfo;
    }

    function initializeSelectForm() {
        $formHtml = '<div class="row">
            <div class="col-sm-7"><form method="get" action="carousel.php">
            <select name="catId" class="form-select">';
        $breedInfo = $_SESSION["breedInfo"];
        for ($i=0; $i < count($breedInfo); $i++) {
            $thisName = $breedInfo[$i]->name;
            $thisId = $breedInfo[$i]->id;
            $formHtml .= '<option value="' . $thisId . '">' . $thisName . '</option>';
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

    function getImages() {
        $url = "https://api.thecatapi.com/v1/images/search?breed_ids=" . $_GET["catId"] . "&limit=10";
        $imagesRaw = file_get_contents($url);
        $images = json_decode($imagesRaw);
        $imgUrlArray = [];
        for ($i=0; $i < 10; $i++) {
            $imgUrl = $images[$i]->url;
            $imgUrlArray[$i] = $imgUrl;
        }
        $_SESSION["imgUrlArray"] = $imgUrlArray;
    }

    function fillCarousel() {
        $imgUrlArray = $_SESSION["imgUrlArray"];
        $imageHtml = '';
        for ($i=0; $i < count($imgUrlArray); $i++) {
            $imageHtml .= '<div class="carousel-item';
            if ($i == 0) {
                $imageHtml .= ' active';
            }
            $imageHtml .= '"> <img src=' . $imgUrlArray[$i] .  ' class="d-block w-100" alt="Cat ' . ($i + 1) . '"> </div>';
        }
        echo($imageHtml);
    }
?>

