<?php
include_once 'files/rootDirectory.php';
include_once 'files/categories.php';
echo '<script src="'.$root_directory.'/js/vanilla-toast.min.js"></script>';

?>

<head>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-0T4EYQNQPY"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-0T4EYQNQPY');
	</script>
</head>

<header class="header">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="header__content">
					<a href="<?php echo $root_directory?>" class="header__logo" style="font-size:25px;font-family:tahoma;font-weight:bold;">
						<!-- <span style="color:#7ac37d;">MOVIES</span><span style="color:#fff;">GOO</span> -->
						<img src="<?php echo $root_directory?>/img/home/logo.png" alt="Movies Goo">
					</a>
					<ul class="header__nav">
						<li class="header__nav-item">
							<a class="header__nav-link" href="<?php echo $root_directory?>">Home</a>
						</li>
						<li class="header__nav-item">
							<a href="<?php echo $root_directory?>/recent.php" class="header__nav-link">All Movies</a>
						</li>
						<li class="header__nav-item">
							<div class="dropdown">
								<button class="header__nav-link dropdown-toggle" type="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Categories
								</button>
								<div class="dropdown-menu" aria-labelledby="customDropdown">
									<?php
									foreach ($category as $item) {
									?>
										<a class="dropdown-item" href="<?php echo $root_directory?>/category.php?query=<?php echo strtolower($item); ?>"><?php echo $item; ?></a>
									<?php
									}
									?>
								</div>
							</div>
						</li>
						<li class="header__nav-item">
							<a href="<?php echo $root_directory?>/contact.php" class="header__nav-link">Contact Us</a>
						</li>
					</ul>


					<div class="header__auth">
						<form action="<?php echo $root_directory?>/search.php" class="header__search" method="GET">
							<input class="header__search-input" name="query" type="text" value="" placeholder="search movies by name...">
							<button class="header__search-button" type="submit">
								<i class="icon ion-ios-search"></i>
							</button>
							<button class="header__search-close" type="button">
								<i class="icon ion-md-close"></i>
							</button>
						</form>

						<button class="header__search-btn" type="submit">
							<i class="icon ion-ios-search"></i>
						</button>
					</div>

					<!-- header menu btn -->
					<button class="header__btn" type="button">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<!-- end header menu btn -->
				</div>
			</div>
		</div>
	</div>
</header>