<?php
ini_set('display_errors', 0);
include_once 'files/apikey.php';
include_once 'files/datafile.php';

$jsonown = file_get_contents($datafile);		
$data = json_decode($jsonown, true);
$loop = $data[0]['data'];

$slug = $_GET['slug'];

foreach ($loop as $item) {
	if ($item['slug'] == $slug) { 
        $getimdb = basename($item['imdb']);
        break;
    }
}

$wtitle = array();

foreach($loop as $jsonArrayKeyz => $jsonArrayValue){
		$imdblink = $jsonArrayValue['imdb'];
		$imdb = basename($imdblink);
		if($getimdb == $imdb){
			$wtitle[] = $jsonArrayValue['title'];
		}
}

$json = file_get_contents('http://api.themoviedb.org/3/movie/'.$getimdb.'?api_key='.$apikey);	
$obj = json_decode($json, true);
$tmdbid = $obj["id"];
$imdbid = $obj["imdb_id"];
$title = $obj["title"];
$duration = $obj["runtime"];
$genres = $obj["genres"];
$plot = $obj["overview"]; 
$poster = '//image.tmdb.org/t/p/original'.$obj["poster_path"];
$country = $obj["production_countries"][0]["name"];

								$genres1 = isset($genres[0])?$genres[0]['name']:'';

								$genres2 = isset($genres[1])?$genres[1]['name']:'';


$wordcount = implode(' ', array_slice(str_word_count($plot,1), 0, 35));

if (strlen($wordcount) > 35) {
	$words20 = $wordcount.'...';
}

$desc = implode(' ', array_slice(str_word_count($plot,1), 0, 20));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="robots" content="index, follow">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?php echo implode($wtitle);?> – MoviesGoo Movie Script by 2Embed.cc</title>
<meta name="description" content="Watch <?php echo $title;?> Online, <?php echo $desc;?>">
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
<style>
.pswp__caption__center {
	text-align: center;
}
</style>
</head>
<body class="body">
<?php include_once('files/header.php');
 
?>
<!-- details -->
<section class="section section--details section--bg" data-bg="/img/section/details.jpg">
<!-- details content -->
<div class="container">
	<div class="row">
		<!-- title -->
		<div class="col-12">
			<h1 class="section__title"><?php echo implode($wtitle);?></h1>
		</div>
		<!-- end title -->

		<!-- content -->
		<div class="col-12 col-lg-6">
			<div class="card card--details">
				<div class="row">
					<!-- card cover -->
					<div class="col-12 col-sm-5 col-lg-6 col-xl-5">
						<div class="card__cover">
							<img src="<?php echo $poster;?>" onerror="this.src='./img/noposter.jpg';">
							<?php
								foreach($loop as $jsonArrayKeyz => $jsonArrayValue){
										$imdblink = $jsonArrayValue['imdb'];
										$imdb = basename($imdblink);
									if($imdb == $getimdb){
										$rating = $jsonArrayValue['rating'];
										if(empty($rating)) $rating = '0';
							?>									
							<span class="card__rate card__rate--green">asd<?php echo $rating;?></span>
							<?php }} ?>
						</div>
					</div>
					<!-- end card cover -->

					<!-- card content -->
					<div class="col-12 col-sm-7 col-lg-6 col-xl-7">
						<div class="card__content">
							<ul class="card__meta">
								<?php
								foreach($loop as $jsonArrayKeyz => $jsonArrayValue){
										$imdbshort = $jsonArrayValue['imdb'];
										$imdbb = basename($imdbshort);
									if($imdbb == $getimdb){
										$imdblink = $jsonArrayValue['imdb'];
										$imdb = basename($imdblink);											
										$rating = $jsonArrayValue['rating'];
										$year = $jsonArrayValue['year'];
										$language = $jsonArrayValue['language'];
										if(empty($rating)) $rating = '0';
								?>
								<li><span>IMDB:</span><a rel="nofollow" href="<?php echo $imdblink;?>" target="_blank"><?php echo $rating;?></a></li>										
								<li><span>Release Year:</span><a><?php echo $year;?></a></li>										
								<li><span>Language:</span><a><?php echo $language;?></a></li>
								<?php }} ?>									
								<li><span>IMDB-ID:</span><a><?php echo $imdb;?></a></li>
								<li><span>TMDB-ID:</span><a><?php echo $tmdbid;?></a></li>										
								<li><span>Genre:</span><a><?php echo $genres1;?></a><a><?php echo $genres2;?></a></li>
								<li><span>Runtime:</span><a><?php echo $duration;?> min</a></li>
								<li><span>Release Country:</span><a><?php echo $country;?></a></li>
							</ul>
							<div class="card__description">
								<span style="color:#7ac37d;">Plot</span><br>
								<?php echo $plot;?>
							</div>
						</div>
					</div>
					<!-- end card content -->
				</div>
			</div>
		</div>
		<!-- end content -->

		<!-- player -->
		<div class="col-12 col-lg-6">
			<iframe src="https://www.2embed.cc/embed/<?php echo $imdb;?>" style="width:100%;height:365px;" frameborder="0" scrolling="no" allowfullscreen></iframe>
		</div>
		<!-- end player -->
	</div>
</div>
<!-- end details content -->
</section>
<!-- end details -->

<!-- content -->
<section class="content">
<div class="content__head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!-- content tabs nav -->
				<ul class="nav nav-tabs content__tabs" id="content__tabs" style="display:block;">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">ScreenShots</a>
					</li>
				</ul>
				<!-- end content tabs nav -->
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-12 col-lg-8 col-xl-8">
			<!-- content tabs -->
			<div class="tab-content" style="border-right:2px solid #7ac37d;">
				<div class="tab-pane fade show active" id="tab-3" role="tabpanel" aria-labelledby="3-tab">
					<!-- project gallery -->
					<div class="gallery" itemscope>
						<div class="row">
							<?php
								$json = file_get_contents('http://api.themoviedb.org/3/movie/'.$getimdb.'/images?api_key='.$apikey);	
								$obj = json_decode($json, true);
								$imgdata = $obj["backdrops"];
								$imgdata = array_reverse($imgdata);
								if(empty($imgdata)){
							?>								
							<!-- gallery item -->
							<figure class="col-12 col-sm-6 col-xl-4" itemprop="associatedMedia" itemscope>
								<a href="/img/noscreen.png" itemprop="contentUrl" data-size="1920x1280">
									<img src="/img/noscreen.png" itemprop="thumbnail" alt="<?php echo $title;?>" />
								</a>
							</figure>
							<!-- end gallery item -->
							<?php 
							}else{
								foreach($imgdata as $jsonArrayKeyz => $jsonArrayValue){
									$relimg = $jsonArrayValue['file_path'];							
							?>
							<!-- gallery item -->
							<figure class="col-12 col-sm-6 col-xl-4" itemprop="associatedMedia" itemscope>
								<a href="//image.tmdb.org/t/p/original<?php echo $relimg;?>" itemprop="contentUrl" data-size="1920x1280">
									<img src="//image.tmdb.org/t/p/original<?php echo $relimg;?>" itemprop="thumbnail" alt="<?php echo $title;?>" />
								</a>
								<figcaption itemprop="caption description"><?php echo $title;?> (Images)</figcaption>
							</figure>
							<!-- end gallery item -->
							<?php }} ?>
						</div>
					</div>
					<!-- end project gallery -->
				</div>
			</div>
			<!-- end content tabs -->
		</div>

		<!-- sidebar -->
		<div class="col-12 col-lg-4 col-xl-4">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title">You may also like...</h2>
				</div>
				<!-- end section title -->
				<?php
					$counter = 0;
					shuffle($loop);
					
					foreach($loop as $jsonArrayKeyz => $jsonArrayValue){
							if ($counter >= 6) {
							   break;
							}
							$slug = $jsonArrayValue['slug'];
						
						$title = $jsonArrayValue['title'];
						$imdbid = $jsonArrayValue['imdb'];
						$rating = $jsonArrayValue['rating'];
						$language = $jsonArrayValue['language'];
						$year = $jsonArrayValue['year'];
						
						$imdbid = basename($imdbid);
						
						if(empty($rating)) $rating = '0';

						$json = file_get_contents('http://api.themoviedb.org/3/movie/'.$imdbid.'?api_key='.$apikey);	
						$obj = json_decode($json, true);
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
				<div class="col-6 col-sm-4 col-lg-6" title="<?php echo $title;?> (<?php echo $year;?>)">
					<div class="card">
						<div class="card__cover">
							<img src="<?php echo $poster;?>" alt="Watch <?php echo $title;?>" onerror="this.src='./img/noposter.jpg';" alt="Watch <?php echo $title;?> Online">
							<a href="./watch.php?slug=<?php echo $slug;?>" class="card__play">
								<i class="icon ion-ios-play"></i>
							</a>
							<div class="new-badges">
											<?php if ($rating) { ?>
												<span class="card__rate card__rate--green"><?php echo $rating; ?> &nbsp; <i class="icon ion-ios-star"></i></span>
											<?php } ?>
											<span class="card__rate card__rate--green"><?php echo $year; ?></span>
										</div>						</div>
						<div class="card__content">
							<h3 class="card__title">
								<a href="./watch.php?slug=<?php echo $slug;?>"><?php echo $title;?></a>
							</h3>
							<span class="card__category">
							<a><?php echo $genres1;?></a>
							<a><?php echo $genres2;?></a>
							</span>
						</div>
					</div>
				</div>
				<!-- end card -->
				<?php 
					$counter++;						
				}
				?>
			</div>
		</div>
		<!-- end sidebar -->
	</div>
</div>
</section>
<!-- end content -->

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
	<!-- Background of PhotoSwipe. 
	It's a separate element, as animating opacity is faster than rgba(). -->
	<div class="pswp__bg"></div>
	<!-- Slides wrapper with overflow:hidden. -->
	<div class="pswp__scroll-wrap">
		<!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
		<!-- don't modify these 3 pswp__item elements, data is added later on. -->
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>
		<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
		<div class="pswp__ui pswp__ui--hidden">
			<div class="pswp__top-bar">
				<!--  Controls are self-explanatory. Order can be changed. -->
				<div class="pswp__counter"></div>
				<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
				<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
				<!-- Preloader -->
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>
			<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
			<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>
		</div>
	</div>
</div>
<?php include_once('files/footer.php');?>
</body>
</html>