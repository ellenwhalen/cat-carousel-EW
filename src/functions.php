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
        // Admittedly the starArray is a kind of silly way of doing it, but it's fast and works well :)
        // I know I could do it in a smarter way with loops but why bother when it's only 6 options
        $_SESSION["starArray"] = ['<span class="rating"> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i>', 
        '<span class="rating"> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i>', 
        '<span class="rating"> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        </span>',
        '<span class="rating"> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        </span>',
        '<span class="rating"> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-regular fa-star"></i> 
        </span>', 
        '<span class="rating"> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        <i class="fa-solid fa-star"></i> 
        </span>'];
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
        for ($i=0; $i < count($images); $i++) {
            $imgUrl = $images[$i]->url;
            $imgUrlArray[$i] = $imgUrl;
        }
        $_SESSION["imgUrlArray"] = $imgUrlArray;
    }

    function setUpIndicators() {
        $imgCount = count($_SESSION["imgUrlArray"]);
        $indicatorHtml = '';
        for ($i=0; $i < $imgCount; $i++) {
            $indicatorHtml .= '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $i . '" class="active" ' ;
            if ($i == 0) {
                $indicatorHtml .= 'aria-current="true" ';
            }
            $indicatorHtml .='aria-label="Slide ' . ($i + 1) . '"></button>';
        }
        echo($indicatorHtml);
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

    function displayCatInfo() {
        $url = 'https://api.thecatapi.com/v1/breeds/' . $_GET["catId"];
        $catInfoRaw = file_get_contents($url);
        $catInfo = json_decode($catInfoRaw);
        echo('<h4>' . $catInfo->name .'</h4>');
        echo('<p><strong>Temperament: </strong>' . $catInfo->temperament . '</p>');
        echo('<p><strong>Origin: </strong>' . $catInfo->origin . '</p>');
        echo('<p><strong>Description: </strong>' . $catInfo->description . '</p>');
        echo('<p><strong>Affection level: </strong>' . $_SESSION["starArray"][$catInfo->affection_level] . '</p>');
        echo('<p><strong>Energy level: </strong>' . $_SESSION["starArray"][$catInfo->energy_level] . '</p>');
        echo('<p><strong>Intelligence: </strong>' . $_SESSION["starArray"][$catInfo->intelligence] . '</p>');
        echo('<p><strong>Social needs: </strong>' . $_SESSION["starArray"][$catInfo->social_needs] . '</p>');
    }

?>

