<div class="currentdate">
	<?php print render($page['currentdate']); ?>
</div>
<div class="block-breadcrumb">
	<?php if (!empty($breadcrumb)): print $breadcrumb; endif;?>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-3">
			<div class="menu-gauche">	
				<?php print render($page['menu-gauche']); ?>
			</div>
		</div>

		<div class="col-xs-12 col-sm-9">
			<div class="text-container single-article">
				<?php if (!empty($title)): ?>
					<?php print "<h2 class='block-title'>" . render($title) . "</h2>";  ?>
				<?php endif; ?>
				<?php print render($page['content']); ?>
				<div class="centered"><a href="/actualites" class="bouton">Retour aux actualités</a></div>
			</div>
		</div>
	</div>
</div>
