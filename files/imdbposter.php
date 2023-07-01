<?php 
ini_set('display_errors',0);
include_once './apikey.php';
header('Content-Type: image/jpeg');
$imdblink = trim(!empty($_GET['imdb'])) ? $_GET['imdb'] : null;

$json = file_get_contents('http://api.themoviedb.org/3/movie/'.$imdblink.'?api_key='.$apikey);	
$obj = json_decode($json, true);
$poster = $obj["poster_path"];

readfile('http://image.tmdb.org/t/p/original'.$poster);


?>