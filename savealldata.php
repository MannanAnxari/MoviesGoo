	<link rel="stylesheet" href="./css/main.css">

	<body class="m-0">

	    <h1 class="bg-dark vh-100 vw-100 d-flex align-items-center justify-content-center" id="dataDownloaded">

	        (0)

	        <?php
            ini_set('display_errors', 0);
            include_once 'files/apikey.php';
            include_once 'files/datafile.php';

            $key = $_GET['query'];

            $json = file_get_contents($datafile);
            $data = json_decode($json, true);
            $loop = $data[0]['data'];

            $counter = 0;

            foreach ($loop as $jsonArrayKeyz => $jsonArrayValue) {

                if ($counter >= 2) {
                    break;
                }

                $imdbid = $jsonArrayValue['imdb'];

                $imdbid = basename($imdbid);

                $json = file_get_contents('http://api.themoviedb.org/3/movie/' . $imdbid . '?api_key=' . $apikey);

                $filename = 'alldata.json';
                $existingData = file_get_contents($filename);

                // Convert JSON data to PHP array
                $existingArray = json_decode($existingData, true);

                // Append new JSON object to the array
                $newObject = json_decode($json, true);
                $existingArray[] = $newObject;

                // Convert the updated array back to JSON
                $updatedData = json_encode($existingArray);

                // Write the updated JSON data back to the file
                file_put_contents($filename, $updatedData);

                echo '<script>dataDownloaded.innerHTML = "(' . $counter . ')"</script>';

                $counter++;
            }
            ?>
	    </h1>
	</body>