<?php
include_once '../files/apikey.php';
include_once '../files/datafile.php';
include_once '../files/rootDirectory.php';

$jsonData = file_get_contents('php://input');

if ($jsonData === false) {
    http_response_code(400); // Bad Request
    echo "Error: Unable to retrieve JSON data";
    exit;
}
$data = json_decode($jsonData, true);


if ($data === null) {
    http_response_code(400); // Bad Request
    echo "Error: Invalid JSON data";
    exit;
}


$allMovies = file_get_contents("./../data.json");
$allMoviesData = json_decode($allMovies, true)[0]['data'];
$imdb = basename($data["imdb"]);

$imdbExists = false;
foreach ($allMoviesData as $movie) {
    if (basename($movie["imdb"]) === $imdb) {
        $imdbExists = true;
        break;
    }
}

if (!$imdbExists) {
    if (isset($data['year'])) {
        $insertIndex = 0;
        foreach ($allMoviesData as $index => $movie) {
            if ($movie['year'] === $data['year']) {
                $insertIndex = $index;
                break;
            }
        }
        array_splice($allMoviesData, $insertIndex, 0, [$data]);
    }
} else {
    $responseData = ['success' => false, 'message' => 'Sale! Movie Pehle Se Hai Hmare Pas! 🥹'];
    echo json_encode($responseData);
    exit;
}

$result = file_put_contents("./../data.json", json_encode([["data" => $allMoviesData]]));

if ($result !== false) {
    $json = file_get_contents('http://api.themoviedb.org/3/movie/' . $imdb . '?api_key=' . $apikey);
    $obj = json_decode($json, true);

    $allMoviesDetailed = json_decode(file_get_contents("./../allDataForMovies.json"), true);

    $newAppendedData = array_unshift($allMoviesDetailed, $obj);

    $bigData = file_put_contents("./../allDataForMovies.json", json_encode($allMoviesDetailed));

    if ($bigData === false) {

        foreach ($allMoviesData as $key => $movie) {
            if (basename($movie["imdb"]) === $imdb) {
                unset($movies[$key]);
                break;
            }
        }

        $allMoviesData = array_values($allMoviesData);
        $result = file_put_contents("./../data.json", json_encode([["data" => $allMoviesData]]));
    }

    $responseData = ['success' => true, 'message' => 'Movie Added Successfully!'];
    echo json_encode($responseData);
    exit;
} else {
    $responseData = ['success' => false, 'message' => 'Something went wrong!'];
    echo json_encode($responseData);
    exit;
}



// $data = file_get_contents("$datafile");
// $json = json_decode($data, true);
// print_r($json);
