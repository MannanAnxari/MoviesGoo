<link rel="stylesheet" href="../css/main.css">

<body class="m-0">
    <h1 class="bg-dark vh-100 vw-100 d-flex align-items-center justify-content-center text-white">
        Images + Data Has Been Downloaded: &nbsp; <span id="dataDownloaded"> (0) </span>
    </h1>
</body>

<?php
set_time_limit(360000);

ini_set('display_errors', 0);
include_once '../files/apikey.php';
include_once '../files/datafile.php';

$key = $_GET['query'];

$json = file_get_contents($datafile);
$data = json_decode($json, true);
$loop = $data[0]['data'];

$counter = 0;
$filename = 'alldataTemp.json';

$existDta = [];
foreach ($loop as $jsonArrayKeyz => $jsonArrayValue) {
    // if ($counter >= 5) {
    //     break;
    // }
    
    $imdbid = $jsonArrayValue['imdb'];
    $imdbid = basename($imdbid);

    $json = file_get_contents('http://api.themoviedb.org/3/movie/' . $imdbid . '?api_key=' . $apikey);
    $obj = json_decode($json, true);
    // $tmdbid = $obj["id"];
    echo str_pad('', 4096) . PHP_EOL;
    
    ob_flush();
    flush();
    
    // $poster = 'https://image.tmdb.org/t/p/original' . $obj["poster_path"];
    
    $existingData = $existDta;
    
    // this code for downloading images 
    // start
    $folderPath = 'dataimages/';
    
    // if ($counter >= 14000) {
        
        //     // Create the folder if it doesn't exist
        //     if (!file_exists($folderPath)) {
            //         mkdir($folderPath, 0777, true);
    //     }

    //     $imagePath = $folderPath . $imdbid . '.' . pathinfo($poster, PATHINFO_EXTENSION);

    //     $imageData = file_get_contents($poster);

    //     if ($imageData === false) {
        //     } else {
            //         file_put_contents($imagePath, $imageData);
            //     }
            // }
            // end
            
            $ct = $counter + 1;
            echo '<script>dataDownloaded.innerHTML = "(' . $ct . ')"</script>';
            
            // Convert JSON data to PHP array
            $existingArray = $existingData;
            
            // Append new JSON object to the array
            $newObject = json_decode($json, true);
            
            array_push($existDta, $newObject);
            // $existingArray[] = $newObject;
             
    // Convert the updated array back to JSON
    // $existDta = json_encode($existingArray);

    // Write the updated JSON data back to the file

    $counter++;
}
file_put_contents($filename, json_encode($existDta));
?>