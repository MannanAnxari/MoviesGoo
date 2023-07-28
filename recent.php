<?php
ini_set('display_errors',0);
include_once 'files/rootDirectory.php';
include_once 'files/apikey.php';
include_once 'files/datafile.php';

$json = file_get_contents($datafile);		
$data = json_decode($json, true);
$loop = $data[0]['data'];
$allMoviesData = json_decode(file_get_contents($dataFileMovies), true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="robots" content="index, follow">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Browse All Movies - MoviesGoo</title>
<link rel="stylesheet" href="./css/bootstrap-reboot.min.css">
<link rel="stylesheet" href="./css/bootstrap-grid.min.css">
<link rel="stylesheet" href="./css/owl.carousel.min.css">
<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="./css/nouislider.min.css">
<link rel="stylesheet" href="./css/ionicons.min.css">
	<link rel="icon" href="<?php echo $root_directory?>/icon/favicon-32x32.png" type="image/png">
<link rel="stylesheet" href="./css/plyr.css">
<link rel="stylesheet" href="./css/photoswipe.css">
<link rel="stylesheet" href="./css/default-skin.css">
<link rel="stylesheet" href="./css/main.css">


<meta name="robots" content="index, follow">
<meta property="og:title" content="MoviesGoo - Stream Animated Movies Online">
<meta property="og:description" content="Watch the latest animated movies online for free on MoviesGoo. Enjoy a vast collection of animated films from various genres.">
<meta property="og:image" content="<?php echo $root_directory; ?>/img/home/logo.png">
<meta property="og:url" content="https://www.moviesgoo.com">
<meta property="og:type" content="website">
<meta property="og:site_name" content="MoviesGoo">

<meta name="description" content="Watch the latest animated movies online for free on MoviesGoo. Enjoy a vast collection of animated films from various genres.">
<meta name="keywords" content="watch online, new movies 2023, animated movies 2023, new animated movies 2023, animated movies, animated films, stream animated movies, watch cartoons, watch animated movies online, free animated movies">
<meta name="author" content="MoviesGoo">
<title>MoviesGoo – Stream Full HD Movies</title>

</head>
<body class="body">
<?php include 'files/header.php';
?>
<!-- page title -->
<section class="section section--first section--bg" data-bg="img/section/section.jpg">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section__wrap">
					<!-- section title -->
					<h2 class="section__title">Browse All Movies</h2>
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
			$page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
			$total = count( $loop );
			$limit = 24;
			$totalPages = ceil( $total/ $limit );
			$page = max($page, 1);
			$page = min($page, $totalPages);
			$offset = ($page - 1) * $limit;
			if( $offset < 0 ) $offset = 0;
			$yourDataArray = array_slice( $loop, $offset, $limit );
			foreach($yourDataArray as $jsonArrayValue) {
				$title = $jsonArrayValue['title']; 
				$imdbid = $jsonArrayValue['imdb'];
				$slug = $jsonArrayValue['slug'];
				$rating = $jsonArrayValue['rating'];
				$language = $jsonArrayValue['language'];
				$year = $jsonArrayValue['year'];
				$imdbid = basename($imdbid);
				if(empty($rating)) $rating = '0';
				// $json = file_get_contents('http://api.themoviedb.org/3/movie/'.$imdbid.'?api_key='.$apikey);	
				// $obj = json_decode($json, true);
				$obj = [];

				$matches = array_filter($allMoviesData, function ($item) use ($imdbid) {
					return basename($item['imdb_id']) === $imdbid;
				});

				if (!empty($matches)) {
					$obj = reset($matches);
				}
				
				// echo "<pre>";
				// print_r($obj);
				// die();

				$tmdbid = $obj["id"];
				$duration = $obj["runtime"];
				$genres = $obj["genres"];
				$year = $obj["release_date"];
				$poster = '//image.tmdb.org/t/p/original'.$obj["poster_path"];
				$country = $obj["production_countries"][0]["name"];
												$genres1 = isset($genres[0])?$genres[0]['name']:'';

												$genres2 = isset($genres[1])?$genres[1]['name']:'';

				$year = substr($year, 0, strpos($year, "-"));
			?>					
			<!-- card -->
			<div class="col-6 col-sm-4 col-md-3 col-xl-2" title="<?php echo $title;?> (<?php echo $year;?>)">
				<div class="card">
					<div class="card__cover">
						<img src="<?php echo $poster;?>" alt="Watch <?php echo $title;?>" onerror="this.src='./img/noposter.jpg';">
						<a href="./watch.php?slug=<?php echo $slug; ?>" class="card__play">
							<i class="icon ion-ios-play"></i>
						</a>
						<div class="new-badges">
											<?php if ($rating) { ?>
												<span class="card__rate card__rate--green"><?php echo $rating; ?> &nbsp; <i class="icon ion-ios-star"></i></span>
											<?php } ?>
											<span class="card__rate card__rate--green"><?php echo $year; ?></span>
										</div>	</div>
					<div class="card__content">
						<h3 class="card__title"><a href="./watch.php?slug=<?php echo $slug;?>"><?php echo $title;?></a></h3>
						<span class="card__category">
							<a><?php echo $genres1;?></a>
							<a><?php echo $genres2;?></a>
						</span>
					</div>
				</div>
			</div>
			<!-- end card -->
			<?php } ?>
			
			<!-- paginator -->
			<div class="col-12">
				<ul class="paginator">
					<?php
						$link = '%d';
						if( $totalPages != 0 ) 
						{
						  if( $page == 1 ) 
						  { 
							$pagerContainer .= ''; 
						  } 
						  else 
						  { 
							$pagerContainer .= sprintf( '<li class="paginator__item paginator__item--prev paginator__item--active"><a href="./recent.php?page='.$link.'" style="width:max-content;padding:0 10px;cursor:pointer;"><i class="icon ion-ios-arrow-back" style="margin-top:1px;"></i> &nbsp; Prev</a></li>', $page - 1 ); 
						  }
						  $pagerContainer .= '<li class="paginator__item paginator__item--active"><a style="width:max-content;padding:0 10px;">' . $page . ' &nbsp; of &nbsp; ' . $totalPages . '</a></li>'; 
						  if( $page == $totalPages ) 
						  { 
							$pagerContainer .= ''; 
						  }
						  else 
						  { 
							$pagerContainer .= sprintf( '<li class="paginator__item paginator__item--next paginator__item--active">
							<a href="./recent.php?page='.$link.'" style="width:max-content;padding:0 10px;cursor:pointer;">Next &nbsp; <i class="icon ion-ios-arrow-forward" style="margin-top:1px;"></i></a></li>', $page + 1 ); 
						  }           
						}
						echo $pagerContainer;
					?>
				</ul>
			</div>
			<!-- end paginator -->
		</div>
	</div>
</div>
<!-- end catalog -->
<?php include_once('files/footer.php');?>
</body>
</html>