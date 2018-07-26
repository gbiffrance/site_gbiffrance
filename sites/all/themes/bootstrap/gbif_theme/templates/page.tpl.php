<?php 
	$display_menu_gauche = True;
	$position_content = "col-xs-12 col-sm-12";
	$menu_gauche = '';

	if (module_exists('search')){
		if (arg(0) == 'search'){
			$vars['title'] = t('Search Results');
			$display_menu_gauche = False;
		}
	}

	if ($display_menu_gauche){
		
		print '<div class="currentdate">' . render($page['currentdate']).'</div>';
		print '<div class="block-breadcrumb"> ';
		if (!empty($breadcrumb)){
			print $breadcrumb;
		}
		print ' </div>';
		$menu_gauche = '<div class="col-sm-3"><div class="menu-gauche">' . render($page['menu-gauche']) .  '</div></div>';
		$position_content = "col-xs-12 col-sm-8";
	}
?>

<div class="container">
	<div class="row">
		<?php print $menu_gauche; ?>
		<div class="<?php print 'bloc text-container ' . $position_content ?>">
			<?php print "<h2 class='block-title'>" . render($title) . "</h2>";  ?>
			<?php print render($page['content']); ?>
		</div>
	</div>
</div>
