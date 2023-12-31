<?php

include_once("./../files/config.php");
// Database connection details
$hostname = $DB_HOST;
$username = $DB_USER;
$password = $DB_PASS;
$database = $DB;



$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM entries WHERE date = CURDATE()";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $todayEntries = $row['today_entries'] + 1;

    $updateQuery = "UPDATE entries SET today_entries = $todayEntries WHERE date = CURDATE()";

    $updtResult = mysqli_query($conn, $updateQuery);
    if ($updtResult) {
        echo $todayEntries;
    } else {
        echo "Error updating value: " . mysqli_error($conn);
    }
} else {
    $insertQuery = "INSERT INTO entries (date, today_entries) VALUES (CURDATE(), 0)";
    if (mysqli_query($conn, $insertQuery)) {
        echo 0;
    } else {
        echo "Error creating new row: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
exit;
