<?php
ini_set('display_errors', 0);
include_once 'files/apikey.php';
include_once 'files/datafile.php';
include_once 'files/config.php';
include_once 'files/rootDirectory.php';

$key = $_GET['query'];

$allMoviesData = json_decode(file_get_contents($dataFileMovies), true);
$json = file_get_contents($datafile);
$data = json_decode($json, true);
$loop = $data[0]['data'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Category Results - <?php echo ucwords($key);?> - MoviesGoo</title>
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/nouislider.min.css">
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/plyr.css">
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/photoswipe.css">
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/default-skin.css">
	<link rel="stylesheet" href="<?php echo $root_directory ?>/css/main.css"> 
	<link rel="icon" href="<?php echo $root_directory?>/icon/favicon-32x32.png" type="image/png">



	<meta name="robots" content="index, follow">
	<meta property="og:title" content="MoviesGoo - Stream Animated Movies Online">
	<meta property="og:description" content="Watch the latest animated movies online for free on MoviesGoo. Enjoy a vast collection of animated films from various genres. Find <?php echo $key;?> and more.">
	<meta property="og:image" content="<?php echo $root_directory; ?>/img/home/logo.png">
	<meta property="og:url" content="https://www.moviesgoo.com">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="MoviesGoo">

	<meta name="description" content="Watch the latest <?php echo $key; ?> movies online for free on MoviesGoo. Enjoy a vast collection of <?php echo $key; ?> films from various genres.">
    <meta name="keywords" content="<?php echo $key; ?> movies, watch <?php echo $key; ?> movies, <?php echo $key; ?> animated films, <?php echo $key; ?> movies online, stream <?php echo $key; ?> movies">
  
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
			<div class="row" id="movie-container">
				<?php
				$counter = 0;

				// $displayedMovies = [];

				// $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number from the URL parameter
				// $itemsPerPage = 48; // Number of items to display per page
				// $offset = ($page - 1) * $itemsPerPage; // Calculate the offset for the current page

				// // Get the movies for the current page using array slice
				// $movies = array_slice($allMoviesData, $offset, $itemsPerPage);

				foreach ($allMoviesData as $jsonArrayKeyz => $jsonArrayValue) {
					$genres = $jsonArrayValue["genres"];

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

					// Rest of your existing code...

					$title = $jsonArrayValue['title'];
					$imdbid = $jsonArrayValue['imdb_id'];
					$rating;
					$slug;
					$language = $jsonArrayValue['language'];
					$year = $jsonArrayValue['year'];

					$matches = array_filter($loop, function ($item) use ($imdbid) {
						return basename($item['imdb']) === $imdbid;
					});

					if (!empty($matches)) {
						$rating = reset($matches)['rating'];
						$slug = reset($matches)['slug']; 
					}

					$imdbid = basename($imdbid);

					if (empty($rating)) {
						$rating = '0';
					}

					$tmdbid = $jsonArrayValue["id"];
					$duration = $jsonArrayValue["runtime"];
					$year = $jsonArrayValue["release_date"];
					$poster = '//image.tmdb.org/t/p/original' . $jsonArrayValue["poster_path"];

					$country = $jsonArrayValue["production_countries"][0]["name"];

					$genres1 = isset($genres[0]) ? $genres[0]['name'] : '';
					$genres2 = isset($genres[1]) ? $genres[1]['name'] : '';

					$year = substr($year, 0, strpos($year, "-"));

				?>
					<!-- card -->
					<div class="col-6 col-sm-4 col-md-3 col-xl-2" title="<?php echo $title; ?> (<?php echo $year; ?>)">
						<div class="card">
							<div class="card__cover">
								<img src="<?php echo $poster; ?>" alt="Watch <?php echo $title; ?>" onerror="this.src='<?php echo $root_directory ?>/img/noposter.jpg';">
								<a href="<?php echo $root_directory ?>/watch.php?slug=<?php echo $slug; ?>" class="card__play">
									<i class="icon ion-ios-play"></i>
								</a>
								<div class="new-badges">
									<?php if ($rating) { ?>
										<span class="card__rate card__rate--green"><?php echo $rating; ?> &nbsp; <i class="icon ion-ios-star"></i></span>
									<?php } ?>
									<span class="card__rate card__rate--green"><?php echo $year; ?></span>
								</div>
							</div>
							<div class="card__content">
								<h3 class="card__title">
									<a href="<?php echo $root_directory ?>/watch.php?slug=<?php echo $slug; ?>"><?php echo $title; ?></a>
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
				<?php
				}

				// if ($counter >= $itemsPerPage) {
				// 	$page++;
				// }
				?>

				<!-- <script>
					var page = <?php echo $page + 1; ?>;
					var loading = false; 

					window.addEventListener('scroll', function() {
						if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight && !loading) {
							loadMoreData();
						}
					});

					function loadMoreData() {
						loading = true;

						setTimeout(function() {
							<?php


							$nextMovies = array_slice($allMoviesData, ($page - 1) * $itemsPerPage, $itemsPerPage);

							foreach ($nextMovies as $jsonArrayKeyz => $jsonArrayValue) {
								$genres = $jsonArrayValue["genres"];

								$hasActionGenre = false;
								if (isset($genres)) {
									foreach ($genres as $genre) {
										if (strtolower($genre['name']) === strtolower($key)) {
											$hasActionGenre = true;
											break;
										}
									}
								}

								if (!$hasActionGenre) {
									continue;
								}

								$title = $jsonArrayValue['title'];
								$imdbid = $jsonArrayValue['imdb_id'];
								$rating;
								$language = $jsonArrayValue['language'];
								$year = $jsonArrayValue['year'];

								$matches = array_filter($loop, function ($item) use ($imdbid) {
									return basename($item['imdb']) === $imdbid;
								});

								if (!empty($matches)) {
									$rating = reset($matches)['rating'];
								} else {
									$rating = '0';
								}

								// $imdbid = basename($imdbid);

								// Check if the movie has already been displayed
								if (in_array($imdbid, $displayedMovies)) {
									continue; // Skip appending duplicate movie
								}

								$displayedMovies[] = $imdbid; // Add IMDb ID to displayedMovies array

								$tmdbid = $jsonArrayValue["id"];
								$duration = $jsonArrayValue["runtime"];
								$year = $jsonArrayValue["release_date"];
								$poster = '//image.tmdb.org/t/p/original' . $jsonArrayValue["poster_path"];

								$country = $jsonArrayValue["production_countries"][0]["name"];

								$genres1 = isset($genres[0]) ? $genres[0]['name'] : '';
								$genres2 = isset($genres[1]) ? $genres[1]['name'] : '';

								$year = substr($year, 0, strpos($year, "-"));
							?>
								var container = document.getElementById('movie-container');
								var newElement = document.createElement('div');
								newElement.className = 'col-6 col-sm-4 col-md-3 col-xl-2';
								newElement.title = '<?php echo $title; ?> (<?php echo $year; ?>)';
								newElement.innerHTML = '<div class="card">' +
									'<div class="card__cover">' +
									'<img src="<?php echo $poster; ?>" alt="Watch <?php echo $title; ?>" onerror="this.src=\'<?php echo $root_directory ?>/img/noposter.jpg\';">' +
									'<a href="<?php echo $root_directory ?>/watch.php?id=<?php echo $imdbid; ?>" class="card__play">' +
									'<i class="icon ion-ios-play"></i>' +
									'</a>' +
									'<span class="card__rate card__rate--green"><?php echo $rating; ?></span>' +
									'</div>' +
									'<div class="card__content">' +
									'<h3 class="card__title">' +
									'<a href="<?php echo $root_directory ?>/watch.php?id=<?php echo $imdbid; ?>"><?php echo $title; ?></a>' +
									'</h3>' +
									'<span class="card__category"><?php echo implode('', array_map(function ($genre) {
																		return '<a>' . $genre['name'] . '</a>';
																	}, $genres)); ?></span>' +
									'</div>' +
									'</div>';
								container.appendChild(newElement);
								console.log(`<?php echo "<pre>";
												print_r($displayedMovies);
												echo in_array($imdbid, $displayedMovies); ?>`);
							<?php
							}
							?>


							loading = false;
							page++;
						}, 1000);
					}
				</script>
 -->

			</div>
		</div>
	</div>
	<!-- end catalog -->
	<?php include_once('files/footer.php'); ?>
</body>

</html>