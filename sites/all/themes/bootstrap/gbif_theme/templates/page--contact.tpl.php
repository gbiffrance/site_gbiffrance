<div class="currentdate">
	<?php print render($page['currentdate']); ?>
</div>
<div class="block-breadcrumb">
	<?php if (!empty($breadcrumb)): print $breadcrumb; endif;?>
</div>
    
<div class="container">
	<div class="row">
		<div class="col-xs-12  col-sm-8">
			<div class="bloc">
				<h2 class="block-title">Contacter le GBIF France</h2>
				<p><i class="icon-question-sign"></i>&nbsp;Pour toutes questions, commentaires, écrivez nous...</p>
				<?php print render($page['content']); ?>
			</div>
		</div>

		<div class="col-xs-12  col-sm-4">
			<div class="bloc">
				<?php print render($page['right-content']); ?>
			</div>
		</div>
	</div>
</div>
