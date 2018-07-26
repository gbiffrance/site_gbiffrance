<div class="frontpage">
	<div class="block-breadcrumb"></div>

	<div class="front-headline1">
		<div class="container">
			<div class="row">
<!--	
				<div class="banniere_message col-xs-12 col-sm-12" style="margin-bottom:2%; border:2px solid #CC424E; border-radius:15px; padding: 20px;">
					<p>Suite &agrave; un probl&egrave;me de m&eacute;moire sur notre messagerie, nous ne sommes pas en mesure de recevoir les e-mails que vous nous envoyez ce mercredi 06 decembre. Nous vous prions de nous excuser et nous vous recommandons de nous les renvoyer ult&eacuterieurement. Merci !</p>
					<p style="text-align:right;">L'&eacute;quipe du GBIF France</p>
				</div>  
-->

				<div class="banniere_message col-xs-12 col-sm-12" style="margin-bottom:2%; border:2px solid #A6AC1A; border-radius:15px; padding: 20px;">
					<p style="margin:auto; font-size:110%; width:90%">Le GBIF.org vient de d&eacute;passer le milliard d'occurrence de donn&eacute;es suite &agrave; la connexion de 930 jeux de donn&eacute;es provenant de l'INPN</p>
					<p style="margin:auto; font-size:110%; width:90%">L'&eacute;quipe du GBIF France tient &agrave; remercier tous les acteurs de cette entreprise et vous invite &agrave; faire circuler la nouvelle</p>
				</div>  
				<div class="heading col-xs-12 col-sm-8">
					<ul>
						<li>
							<div class="pull-right">
								<a href="news.xml"><img src="<?php print base_path().path_to_theme();?>/img/rss16.png" /></a>
							</div>
						</li>
						<li><h2><a href="actualites">Actualit&eacute;s</a></h2></li>
					</ul>    
					<?php print render($page['actualites']); ?>
				</div>
	
				<div class="cadre col-xs-12 col-sm-3">
					<div class="heading">
						<h2><a href="agenda">Agenda</a></h2>
					</div>   
					<?php print render($page['agenda']); ?>
				</div>
		
			</div>

			<div class="row">
				 <div class="block block-presentation col-xs-12 col-sm-8">
                                        <h2><a href="page/none/nos-projets">Focus sur un projet</a></h2>
                                        <?php print render($page['projets']); ?>
                                </div>

                                <div class="directaccess cadre col-xs-12 col-sm-3">
                                        <h2>Acc&egrave;s direct</h2>
                                        <div class="directaccessfond">
                                                <?php print render($page['accesdirects']);?>
                                        </div>
                                </div>
                        </div>

                        <div class="row">

                                <div class="block block-presentation col-xs-12 col-sm-12">
                                        <h2><a href="page/infos/presentation-du-gbif-france">Le GBIF France</a></h2>
                                        <div id="img-pres-gbif">
                                                <a href="page/infos/les-missions-du-gbif-france"><img src="<?php print base_path() . path_to_theme(); ?>/img/img_page_accueil-GBIF_France_Fevrier.png"/></a>
                                        </div>
                                        <div id="text-pres-gbif">                                      
                                                <?php print render($page['content']); ?>
                                        </div>
                                </div>

			  	<div class="gbifinternational">
						 <a href="http://www.afbiodiversite.fr/"  target="_blank" title="Accès au site de l'AFB"><img src="<?php print base_path() . path_to_theme(); ?>/img/logo_AFB-vector.png" id="logo-afb" /></a>
                                                <a href="http://www.gbif.org"  target="_blank" title="Accès au site du GBIF International"><img src="<?php print base_path() . path_to_theme(); ?>/img/logo-gbif.jpg" id="logo-gbif" /></a>
                                                <a href="http://www.ird.fr"  target="_blank" title="Accès au site de l'IRD"><img src="<?php print base_path() . path_to_theme(); ?>/img/logo_ird.png" id="logo-ird" /></a>
                                                <a href="http://www.mnhn.fr"  target="_blank" title="Accès au site du MNHN"><img src="<?php print base_path() . path_to_theme(); ?>/img/Logo_MNHN-Noir.jpg" id="logo-mnhn" /></a>
<a href="http://patrinat.mnhn.fr/"  target="_blank" title="Accès sur le site de l UMS PatriNat"><img src="<?php print base_path() . path_to_theme(); ?>/img/Logo_UMS_patrinat_250px.png" id="logo-patrinat" /></a>
                                                <a href="http://www.upmc.fr"  target="_blank" title="Accès au site de l'UPMC"><img src="<?php print base_path(); ?>sites/default/files/images-partenaires/logo_upmc_250px.png" id="logo-upmc" /></a>						         
				</div>

			</div>
		</div>
	</div>
</div>
