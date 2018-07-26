<?php
 
function getCurl($url)
{
  $ch = curl_init();
  curl_setopt_array($ch, array(CURLOPT_URL => $url,CURLOPT_RETURNTRANSFER => true));
  return curl_exec($ch);
}

function getPublisherStat($uuid){
	$datasetFile  = drupal_get_path('theme', 'gbif_theme')."/json/ds_stat.json";

	$json = file_get_contents($datasetFile);

	$stats =  json_decode($json);

	$exec_date = $stats->script_exec_date;

	foreach($stats->datasets_list as $val){
		if  ($val->institution_uuid==$uuid){
		  return array("institution"=>$val,"script_exec_date"=>$exec_date);
		}
	}
}


function html_table($stat,$exec_date,$uuid){
	$cpt_Geo = 0;
	$cpt_Occ = 0;
	$institution_name = $stat->institution_name;
	$html = '<span class="hidden provider_uuid">'. $uuid .'</span>';
	$html .= "<span class='small'>(Dernière mise à jour des informations le : ".$exec_date.") </span><br /> ";
	$html .= '<table class="table stat-provider table-striped  table-bordered">
		  <thead>
			<tr>
			  <th>Jeu de données</th>
			  <th class="data-number">Nombre de données</th>
			  <th>Téléchargements</th>
			</tr>
		  </thead>
		  <tbody>';
		
	$stat_provider = array("kingdom"=>array(),"basisOfRecord"=>array());

	foreach($stat->datasets_list as $ds){ 


		$ds_url = "http://www.gbif.org/dataset/".$ds->key;
		$ds_search_url ="http://www.gbif.org/occurrence/search?datasetKey=".$ds->key;
		$html .= "<tr>";
		$html .= "<td><b><a target='_blank' class='ds-title' href='".$ds_url."'>".$ds->title."</a></b><br />";
		$html .= "<span>". ucfirst(strtolower($ds->type))  ."</span><br /><br />";

		if ( (isset($ds->dwc_url) && !(empty($ds->dwc_url)))  ) 
			$html .= "<a class='label' href='". $ds->dwc_url ."'>Darwin Core Archive <i class='icon-download-alt'></i></a></td>";

		$html .= (isset($ds->total) && !(empty($ds->total))) ? "<td><b>". $ds->total  ."</b>": "<td>";    
		$html .=  (isset($ds->percent_geo) && !(empty($ds->percent_geo))) ? "<br /><span>Géoréférencées à ".$ds->percent_geo." % </span>": "";
		$html .= "<br /><span><a target='_blank' href=".$ds_search_url.">Consulter <i class='icon-th-list'></i></a></span>";
	  
		// Computes stats (Kingdom / BasisOfRecord)  for Publisher
		if ($ds->type == "OCCURRENCE"){
			foreach($ds->basisOfRecord as $val){
				foreach($val as $k=>$v){
					$stat_provider["basisOfRecord"][$k] = (array_key_exists($k,$stat_provider["basisOfRecord"])) ? $stat_provider["basisOfRecord"][$k] + $v  : $v;
				}
			}
		  
			if (isset($ds->kingdom) && count($ds->kingdom)!=0) {
				foreach($ds->kingdom as $val){
					foreach($val as $k=>$v){
						$stat_provider["kingdom"][$k] = (array_key_exists($k,$stat_provider["kingdom"])) ? $stat_provider["kingdom"][$k] + $v  : $v;
					}
				}
			}
		}

		$cpt_Geo = (isset($ds->georef) && !(empty($ds->georef))) ? $cpt_Geo + $ds->georef : $cpt_Geo;
		$cpt_Occ = (isset($ds->total) && !(empty($ds->total))) ? $cpt_Occ + $ds->total : $cpt_Occ;  

		$html .=  (isset($ds->download) && !(empty($ds->download))) ?  '<td><b>'.$ds->download.'</b><br><a target="_blank" href="'.$ds_url.'/'.'activity"><span class="small"> (voir le détail des téléchargements)</span></a></td>' : '<td>-</td>' ;
		$html .= "</tr>";

	}

	$html .=  '</tbody></table><br />';
	$html .=  '<span class="stat_provider hidden">'.json_encode($stat_provider).'</span>';

	return array("stats_html"=>$html,"total_geo"=>$cpt_Geo,"total_occ"=>$cpt_Occ,"institution_name"=>$institution_name);
}
  
function provider_info($provider,$table){
	if(!empty($table)){
		$cpt_geo	= $table["total_geo"]  ;
		$cpt_occ = $table["total_occ"];

		$percent_geo =  round((($cpt_geo / $cpt_occ) * 100),2) ;


		$html = '<ul class="nav nav-pills no-puce">
		<li class="active"><a data-toggle="tab" href="#publisher-name">Description</a></li>
		<li><a data-toggle="tab" href="#publisher-stats">Contribution</a></li>
		</ul>

		<div class="tab-content">
		<div class="tab-pane active" id="publisher-name">
		<div class="left-descr">
		<blockquote>'.$provider["descr"].'</blockquote>
		</div>

		<div class="right-img-pub">
		<p><a  target="_blank"     href="'.$provider["external_link"].'"><img alt="" title="Visitez le site du fournisseur" src="../sites/default/files/images-partenaires/'.$provider["logo"].'" /></a></p>
		<p><a target="_blank"  href="http://www.gbif.org/publisher/'.$provider["uuid"].'">Page sur le GBIF.org</a></p>
		<p><a target="_blank"  href="http://metadonnee.gbif.fr/public/show/'.$provider["portail"].'">Page sur le portail du GBIF France</a></p>
		<p><a target="_blank"  href="'.$provider["external_link"].'">Site du fournisseur</a></p>
		</div><br /><div class="reset-float"></div>
		';
		if ($cpt_geo!=0) { 
			$html.='<h3>Cartographie</h3>
			<p>Cette carte présente les données géoréférencées fournies par '.$table["institution_name"].'.</p>
			<b>'.$percent_geo.' %</b> des données sont géoréférencées. <br /><br /><div id="map" style="width: 748px; height: 400px"></div>';
		} 


		$html .=	'</div>

		<div class="tab-pane" id="publisher-stats">

		'.$table["stats_html"];


		$html .= '<div id="kingdom-chart" style="min-width: 500px; height: 400px; max-width: 300px; margin: 0 auto"></div>';

		$html .= '<div id="bor-chart"><b>Source des enregistrements</b></div>
		</div>
		</div> ';
	}else{
		$html = '<ul class="nav nav-pills no-puce">
		<li class="active"><a data-toggle="tab" href="#publisher-name">Description</a></li>
		</ul>

		<div class="tab-content">
		<div class="tab-pane active" id="publisher-name">
		<div class="left-descr">
		<blockquote>'.$provider["descr"].'</blockquote>
		</div>

		<div class="right-img-pub">
		<p><a  target="_blank"     href="'.$provider["external_link"].'"><img alt="" title="Visitez le site du partenaire" src="/sites/default/files/images-partenaires/'.$provider["logo"].'" /></a></p>
		<p><a target="_blank"  href="'.$provider["external_link"].'">Site du partenaire</a></p>
		</div><br /><div class="reset-float"></div>
		</div>
		</div> ';
	}

	return $html;
}

/**
*	Selectionne la banniere adequate selon la resolution de l'ecran
*	return : le code PHP contenant la bonne banniere
*/
function choix_header(){
	$header_choisit='
		<script type="text/javascript">
			if(document.body){
				var larg = (document.body.clientWidth);
			}else{
				var arg = (window.innerWidth);
			}
			if(larg<894){
				document.write("");

			}else{
				document.write("<a href=\"'.base_path().'\"><img src=\"'.base_path().path_to_theme().'/img/header_gbif_site.png\"  alt=\"GBIF FRANCE\"></a>");
			}
		</script>';
	return $header_choisit;
}

/**
*	Configure le schema de la page "Connecter des donnees au GBIF" selon la resolution de l'ecran
*	verticale pour les versions mobile et tablette version portrait, horizontale pour les ordinateur et les tablettes version paysage
*	return le code PHP adequat
*/
function choix_schema_connecter_donnees_GBIF(){
		$schema_choisit='<script type="text/javascript">
			if(document.body){
				var larg = (document.body.clientWidth);
			}else{
				var larg = (window.innerWidth);
			}
			
			if(larg>992){
				document.write("<div  id=\"connecter_donnees_GBIF\"><table><tbody><tr><td><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/md-image.png\" style=\"height: 204px; width: 214px;\" /></td><td><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/arrow216.png\" class=\"schema_fleche\" /></td><td><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/primary_data.png\" style=\"height: 170px; width: 151px;\" /></td><td><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/arrow216.png\" class=\"schema_fleche\" /></td><td><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/Database-64.png\" style=\"height: 64px; width: 64px;\" /></td><td><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/arrow216.png\" class=\"schema_fleche\" /></td><td><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/dataportal.png\" style=\"height: 118px; width: 144px;\" /></td></tr><tr><td class=\"rtecenter\"><a href=\"metadonnees\">Métadonnées</a></td><td>&nbsp;</td><td class=\"rtecenter\"><a href=\"donnees-primaires\">Données primaires</a>&nbsp;/ <a href=\"numerisation-des-donnees\">Numérisation</a></td><td>&nbsp;</td><td><a href=\"publication-des-donnees\">Publication (IPT)</a></td><td>&nbsp;</td><td class=\"rtecenter\"><a class=\"ext\" href=\"http://www.gbif.org\" target=\"_blank\">Consultation sur GBIF.org</a></td></tr></tbody></table></div>");
			}else{
				document.write("<div class=\"centered\"><p><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/md-image.png\" style=\"font-size: 13px; line-height: 20px; height: 204px; width: 214px; background-color: rgb(255, 255, 255); display:block;\" /><a href=\"metadonnees\" class=\"schema;\">Métadonnées</a></p><p><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/arrow_down.png\" class=\"schema_fleche\" /></p><p><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/primary_data.png\" style=\"font-size: 13px; line-height: 20px; height: 170px; width: 151px; background-color: rgb(255, 255, 255); display:block;\" /><a href=\"donnees-primaires\" class=\"schema;\">Données primaires</a><span class=\"schema\">&nbsp;/&nbsp;</span><a href=\"numerisation-des-donnees\" class=\"schema\">Numérisation</a></p><p><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/arrow_down.png\" class=\"schema_fleche\" /></p><p><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/Database-64.png\" style=\"font-size: 13px; line-height: 20px; height: 64px; width: 64px; background-color: rgb(255, 255, 255); display:block;\" /><a href=\"publication-des-donnees\" class=\"schema\">Publication (IPT)</a></p><p><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/arrow_down.png\" class=\"schema_fleche\" /></p><p><img alt=\"\" src=\"'.base_path().path_to_theme().'/img/connexion/dataportal.png\" style=\"font-size: 13px; line-height: 20px; height: 118px; width: 144px; background-color: rgb(255, 255, 255); display:block;\" /><a class=\"ext\" href=\"http://www.gbif.org\" class=\"schema\" target=\"_blank\">Consultation sur GBIF.org</a></p></div>");
			}
		</script>';
	return $schema_choisit;
}

function country_map($iso)
{ 
    $url_fr = 'http://api.gbif.org/v1/occurrence/search?publishing_country=FR&limit=0';
    $resultat_fr = getCurl($url_fr);
    $json_fr = json_decode($resultat_fr);
    $total_occ_fr = $json_fr->count;
      
    $url_fr_geo='http://api.gbif.org/v1/occurrence/count?publishingCountry=FR&isGeoreferenced=true';
    $resultat_fr_geo = getCurl($url_fr_geo);
    $json_fr_geo = json_decode($resultat_fr_geo);
    $total_occ_fr_geo = $json_fr_geo;    
    $html = '<span class="hidden country_iso">'. $iso .'</span>';
	
	$html.='<strong>Les données fournies par la France</strong> : ';	
    $html.='<strong>'.number_format($total_occ_fr, 0, ',', ' ').'</strong> occurrences dont <strong>'.number_format($total_occ_fr_geo, 0, ',', ' ').'</strong> g&eacute;o-r&eacute;f&eacute;renc&eacute;es.';
    $html.='<br /> <br />';
    $html.='<div id="map" style="width: 748px; height: 400px"></div>'; 
    $html.='<br />';
	return $html; 
}

/**
*	Affiche les publication de gbif.org publie sur Mendeley
*	return le code PHP permettant l'affichage des publications
*/
function dataset_GBIF_API(){
	
	$url_API_GBIF = 'http://api.gbif.org/v1/dataset/search?publishingCountry=FR';
        $datasets_json = getCurl($url_API_GBIF);
        $array_datasets = json_decode($datasets_json);

	$html_datasets ='<h2>Liste des Datasets</h2>
				<div id="datasets">';
			
	$results_datasets = $array_datasets->{'results'};
			
	foreach($results_datasets as $dataset){
		$html_datasets .= '<div class="dataset">';
		$html_type = '<p class="type">'.$dataset->{'type'};
		$html_title = '<p class="title">'.$dataset->{'title'};
		$html_description = '<p class="description">'.$dataset->{'description'};

		$html_datasets .= $html_type.$html_title.$html_description.'</div>';
        }

        return $html_datasets.'</div>';		 
}


/**
*       Renvoi les publications de gbif.org publies sur Mendeley
*       grace aux flus json sous forme d'un tableau
*       return un tableau contenant le code PHP permettant l'affichage des publications
*/
function publications_GBIF_json_tab(){

        $url_json = 'https://www.gbif.org/api/resource/search?contentType=literature&countriesOfResearcher=FR';
	$publications_json = getCurl($url_json);
	$objet_publications = json_decode($publications_json);

	$tab_publications = array();
	$array_infos_publications = $objet_publications->{"results"};


	foreach($array_infos_publications as $key_publication=>$content_publication){

		    $html_authors = '<span class="auteurs">';
		    $authors = $content_publication->{"authors"};

		    foreach($authors as $author){
		            $html_authors .= '<p class="auteur">'.$author->{"lastName"}.' '.$author->{"firstName"}[0].', ';
		    }

		    $html_authors .= '<p class="annee">('.$content_publication->{'year'}.')</p></span>';

		    $html_title = '<h3 class="titre"><a title="Aller à l\'article" href="'.$content_publication->{'websites'}[0].'">'.$content_publication->{'title'}.'</a></h3>';
		    $html_source = '<p class="source">'.$content_publication->{'source'}.'</p>';
		    $html_abstract = '<p class="abstract">'.$content_publication->{'abstract'}.'</p>';

		    $html_keywords = '';
		    $keywords = $content_publication->{'keywords'};

		    if(!empty($keywords)){

		            $html_keywords .= '<span class="mot_cles"> Keywords : ';

		            foreach($keywords as $keyword){
		                    $html_keywords .= '<p class="mot_cle">'.$keyword.',</p> ';
		            }

		            $html_keywords .= '</span>';
		    }

		    $tab_publications[] = '<div class="publication">'.$html_authors.$html_title.$html_source.$html_abstract.$html_keywords.'</div>';
	}

	return $tab_publications;
}


?>
