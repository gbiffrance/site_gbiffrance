<?php

/**
 * @file
 * Default theme implementation to format the simplenews newsletter footer.
 *
 * Copy this file in your theme directory to create a custom themed footer.
 * Rename it to simplenews-newsletter-footer--[tid].tpl.php to override it for a
 * newsletter using the newsletter term's id.
 *
 * @todo Update the available variables.
 * Available variables:
 * - $build: Array as expected by render()
 * - $build['#node']: The $node object
 * - $language: language code
 * - $key: email key [node|test]
 * - $format: newsletter format [plain|html]
 * - $unsubscribe_text: unsubscribe text
 * - $test_message: test message warning message
 * - $simplenews_theme: path to the configured simplenews theme
 *
 * Available tokens:
 * - [simplenews-subscriber:unsubscribe-url]: unsubscribe url to be used as link
 *
 * Other available tokens can be found on the node edit form when token.module
 * is installed.
 *
 * @see template_preprocess_simplenews_newsletter_footer()
 */
?>
<?php if (!$opt_out_hidden): ?>
  <?php if ($format == 'html'): ?>
<!--    
<p class="newsletter-footer"><a href="[simplenews-subscriber:unsubscribe-url]" class="bouton"><?php print render($unsubscribe_text); ?></a></p>
-->
	<p class="newsletter-footer"><a href="https://ofb.gouv.fr" target="_blank" title="Accès au site de l'OFB"><img src="http://www.gbif.fr/sites/all/themes/bootstrap/gbif_theme/img/newsletter-logo-ofb.png" id="newsletter-logo-afb" /></a><a href="https://www.gbif.org" target="_blank" title="Accès au site du GBIF International"><img src="http://www.gbif.fr/sites/all/themes/bootstrap/gbif_theme/img/newsletter-logo-gbif.png" id="newsletter-logo-gbif" /></a><a href="https://www.ird.fr" target="_blank" title="Accès au site de l'IRD"><img src="http://www.gbif.fr/sites/all/themes/bootstrap/gbif_theme/img/newsletter-logo-ird.png" id="newsletter-logo-ird" /></a><a href="https://www.mnhn.fr" target="_blank" title="Accès au site du MNHN"><img src="http://www.gbif.fr/sites/all/themes/bootstrap/gbif_theme/img/newsletter-logo-mnhn.png" id="newsletter-logo-mnhn" /></a><a href="https://patrinat.mnhn.fr" target="_blank" title="Accès au site de l'UMS Patrinat"><img src="http://www.gbif.fr/sites/all/themes/bootstrap/gbif_theme/img/newsletter-logo-patrinat.png" id="newsletter-logo-ums" /></a><a href="https://sciences.sorbonne-universite.fr" target="_blank" title="Accès au site de l'UPMC"><img src="http://www.gbif.fr/sites/all/themes/bootstrap/gbif_theme/img/newsletter-logo-sorbonne.png" id="newsletter-logo-upmc" /></a>
        <a href="http://www.gbif.fr/page/none/politique-de-protection-des-donnees">Politique de confidentialité des données du GBIF France</a>
		<a href="[simplenews-subscriber:unsubscribe-url]" class="bouton">Se désabonner</a>
	</p>
<?php else: ?>
  -- <?php print $unsubscribe_text ?>: [simplenews-subscriber:unsubscribe-url]
  <?php endif ?>
<?php endif ?>

<?php if ($key == 'test'): ?>
- - - <?php print $test_message ?> - - -
<?php endif ?>
