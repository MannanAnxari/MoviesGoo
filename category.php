<?php
ini_set('display_errors', 0);
include_once 'files/apikey.php';
include_once 'files/datafile.php';
include_once 'files/config.php';

$key = $_GET['query'];

$json = file_get_contents($datafile);
$data = json_decode($json, true);
$loop = $data[0]['data'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Category Results - Filmato</title>
	<link rel="stylesheet" href="./css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="./css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="./css/owl.carousel.min.css">
	<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="./css/nouislider.min.css">
	<link rel="stylesheet" href="./css/ionicons.min.css">
	<link rel="stylesheet" href="./css/plyr.css">
	<link rel="stylesheet" href="./css/photoswipe.css">
	<link rel="stylesheet" href="./css/default-skin.css">
	<link rel="stylesheet" href="./css/main.css">
</head>

<body class="body">
	<?php include 'files/header.php'; ?>
	<!-- page title -->
	<section class="section section--first section--bg" data-bg="img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">Category for &raquo; <?php echo $key; ?></h2>
						<!-- end section title -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

	<!-- catalog -->
	<div class="catalog">
		<div class="container">
			<div class="row">
				<?php
				$counter = 0;

				foreach ($loop as $jsonArrayKeyz => $jsonArrayValue) {

					if ($counter >= $category_page_items_to_show) {
						break;
					}

					$title = $jsonArrayValue['title'];
					$imdbid = $jsonArrayValue['imdb'];
					$rating = $jsonArrayValue['rating'];
					$language = $jsonArrayValue['language'];
					$year = $jsonArrayValue['year'];

					$imdbid = basename($imdbid);

					if (empty($rating)) $rating = '0';

					$json = file_get_contents('http://api.themoviedb.org/3/movie/' . $imdbid . '?api_key=' . $apikey);

					$obj = json_decode($json, true);
					$tmdbid = $obj["id"];
					$duration = $obj["runtime"];
					$genres = $obj["genres"];
					$year = $obj["release_date"];
					$poster = '//image.tmdb.org/t/p/original' . $obj["poster_path"];

					$country = $obj["production_countries"][0]["name"];

					$genres1 = isset($genres[0]) ? $genres[0]['name'] : '';
					$genres2 = isset($genres[1]) ? $genres[1]['name'] : '';

					$year = substr($year, 0, strpos($year, "-"));

					// Check if genres contain "action"
					$hasActionGenre = false;
					if (isset($genres)) {
						foreach ($genres as $genre) {
							if (strtolower($genre['name']) === strtolower($key)) {
								$hasActionGenre = true;
								break;
							}
						}
					}

					// Skip the loop iteration if no "action" genre found
					if (!$hasActionGenre) {
						continue;
					}
				?>
					<!-- card -->
					<div class="col-6 col-sm-4 col-md-3 col-xl-2" title="<?php echo $title; ?> (<?php echo $year; ?>)">
						<div class="card">
							<div class="card__cover">
								<img src="<?php echo $poster; ?>" alt="Watch <?php echo $title; ?>" onerror="this.src='./img/noposter.jpg';">
								<a href="./watch.php?id=<?php echo $imdbid; ?>" class="card__play">
									<i class="icon ion-ios-play"></i>
								</a>
								<span class="card__rate card__rate--green"><?php echo $rating; ?></span>
							</div>
							<div class="card__content">
								<h3 class="card__title">
									<a href="./watch.php?id=<?php echo $imdbid; ?>"><?php echo $title; ?></a>
								</h3>
								<span class="card__category">
									<!-- <a><?php echo $genres1; ?></a>
									<a><?php echo $genres2; ?></a> -->

									<?php
									if (isset($genres)) {
										foreach ($genres as $genre) {
											echo '<a>' . $genre['name'] . '</a>';
										}
									}
									?>
								</span>
							</div>
						</div>
					</div>
					<!-- end card -->
				<?php
					$counter++;

					if ($counter >= 48) {
						break;
					}
				}
				?>

			</div>
		</div>
	</div>
	<!-- end catalog -->
	<?php include_once('files/footer.php'); ?>
</body>

</html>