<?php

/**
 * @file template.php
 * /!\ Attention NE PAS laisser d'espace à la fin du fichier car cela casse la générération des pages (exemples : Flux RSS)
 */
include drupal_get_path('theme', 'gbif_theme') . '/include_func.inc';

function display_publisher($publisher)
{
  if(!empty($publisher["uuid"])){
  	$stat  = getPublisherStat($publisher["uuid"]);
  	$table =   html_table($stat["institution"],$stat["script_exec_date"],$publisher["uuid"]);
  	return provider_info($publisher,$table);  
  } else {
	return provider_info($publisher, ""); 
  }
}

function display_map($country)
{
  return country_map($country);
}

function block_id(&$block) {
  $info = module_invoke($block->module, 'block', 'list');
  if ($info[$block->delta]['info']) {
    $block_id = 'block-' . $block->module . '-' . $info[$block->delta]['info'];
    $block_id = str_replace(array(' ', '_'), '-', strtolower($block_id));
    return preg_replace('/[^\-a-z0-9]/', '', $block_id);
  } else {
    return 'block-' . $block->module . '-' . $block->delta;
  }
}

/* Override le AllDay sur l'agenda du GBIF*/
function gbif_theme_date_all_day_label() 
{ 
	return '(journée)'; 
}

/* Fonction qui permet d'utiliser les ALIAS des pages comme nom de fichier pour 
overider les pages du templates => http://drupal.stackexchange.com/questions/52408/template-file-naming-with-alias */
/* Utilise le premier segment de l'URL pour déterminer le fichier de template correspondant à ce segment */
function gbif_theme_preprocess_page(&$vars) 
{
  if ($node = menu_get_object()) 
  {
    $path_array = explode('/', drupal_get_path_alias());

    $path = $path_array[0];
    // Ancien code ... 
    //$alias = drupal_get_path_alias("node/$node->nid");
    //Remove slashes from the potential filename
    //$clean_alias = str_replace('/', '__', $alias);
    //$vars['theme_hook_suggestions'][] = 'page__node__' . $clean_alias;
   $vars['theme_hook_suggestions'][] = 'page__node__' . $path;
  }
  
    if (!empty($vars['node']) && !empty($vars['node']->type)) {
    $vars['theme_hook_suggestions'][] = 'node--' . $vars['node']->type;
   }
}

function gbif_theme_preprocess_html(&$variables) {
    $variables['navigation'] = block_get_blocks_by_region('navigation');
    $variables['footer'] = block_get_blocks_by_region('footer');
}


function gbif_theme_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    // HTML5 placeholder attribute
    $form['search_block_form']['#attributes']['placeholder'] = t('Recherche dans le site');
  }
}
?>
