<!DOCTYPE html>

<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<html xml:lang="fr" lang="fr" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php print $head; ?>
		<title><?php print $head_title; ?></title>

		<?php 
			print $scripts;
			$path = current_path();
			$path_alias = drupal_lookup_path('alias',$path);
			$curAlias = substr($path_alias, 0,11);
			if ($curAlias=="partenaires" || $curAlias == "page/infos/" )
			{
				echo '<script src="https://code.highcharts.com/highcharts.js"></script>';
				echo '<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>';	
				echo '<script src="//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v0.0.2/Leaflet.fullscreen.min.js"></script>';
			}
		?>
		<link rel="stylesheet" href="<?php print base_path();?>sites/all/libraries/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php print base_path().path_to_theme();?>/css/print.css" type="text/css" media="print" />

		<?php print $styles; ?>
		<?php 
			if ($curAlias == "partenaires" || $curAlias == "page/infos/" )
			{
				echo '<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />';
				echo "<link href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v0.0.2/leaflet.fullscreen.css' rel='stylesheet' />";
			}
		?> 
		<link rel="stylesheet" href="<?php print base_path();?>sites/all/themes/bootstrap_3.3.4/css/overrides.css" type="text/css" media="screen" />
		<!--[if gte IE 7]>
		 <link type="text/css" rel="stylesheet" href="<?php print base_path().path_to_theme();?>/css/style-ie.css" />
 <link type="text/css" rel="stylesheet" href="/opt/gbif/www/public/site-gbif/sites/all/themes/bootstrap/gbif_theme/css/style-ie.css" />
		<![endif]-->

		<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500|Open+Sans:400,700' rel='stylesheet' type='text/css'>
	</head>
	<body class="<?php print $classes; ?>" <?php print $attributes;?>>
		<?php print $page_top; ?>

		<div id="header" class="row-fluid">
			<?php
				$banniere=choix_header();
				print $banniere;
			?>
		</div>

		<div class="navbar-header format">	
			<div class="contenu_page">
				<div class="row">
					<div class="menu_navigation col-xs-12 col-sm-8">
						<?php 
							echo render($navigation);
						?>
					</div>
					<div class="menu_search col-xs-12 col-md-3">
						<?php
							$block = module_invoke('search', 'block_view', 'search');
							print render($block);
						?>
					</div>
				</div>
			</div>
		</div>
		
  		<div class="clearfix visible-sm visible-md visible-lg"></div>

		<div class="content format">
			<div class="contenu_page">
				<?php print $page; ?>
			</div>
		</div>
		
  		<div class="clearfix visible-sm visible-md visible-lg"></div>

		<div id="footer">
			<div class="region-footer">
				<div class="contenu_page">
					<?php print render($footer); ?>
				</div>
			</div>
		</div>

		<div class="back-to-top">
			<a href="<?php echo $_SERVER['REQUEST_URI']; ?>#top"><img src="<?php print base_path() . path_to_theme(); ?>/img/fleche_top.png"" alt="Revenir en haut" class="toplink"></a>
		</div>
		<?php print $page_bottom; ?>
	</body>
</html>
