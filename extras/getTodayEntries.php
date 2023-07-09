<?php
// Database connection details
$hostname = "localhost";
// $username = "root";
// $password = "";
// $database = "movies_goo";
 
$username = "u864070710_Mannan";
$password = "Mannan.1@";
$database = "u864070710_movies_goo";

$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM entries WHERE date = CURDATE()";
$result = mysqli_query($conn, $query);
$todayEntries = 0;

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $todayEntries = $row['today_entries'];
} else {
    $todayEntries = 0;
}

$response = ["success" => true, "data" => $todayEntries];

echo json_encode($response);
mysqli_close($conn);
exit;
