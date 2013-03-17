<?php
/*
Plugin Name: Easy Theme Switcher
Plugin URI: http://feelsen.com/theme-switcher
Description: Theme Switcher allows your site visitors change the wordpress theme.
Version: 1.0.2
Author: Sérgio Vilar
Author URI: http://about.me/vilar
License: GPL
*/
//session_start();

function esw_set_theme($theme){
 // $_SESSION['tema'] = $_GET['theme'];
  setcookie('tema',  $_GET['theme'], time()+60*60*24*30);
  $_COOKIE['tema'] =  $_GET['theme'];
}

if(!empty($_GET['theme'])):
  
  esw_set_theme($_GET['theme']);

endif;


function esw_determine_theme()
  {

      //$theme = $_SESSION['tema'];
      $theme = $_COOKIE['tema'];
      
      $theme_data = get_theme($theme);
      
      if (!empty($theme_data)) {

          if (isset($theme_data['Status']) && $theme_data['Status'] != 'publish') {
              return false;
          }
          return $theme_data;
      }
      

      $themes = get_themes();
      
      foreach ($themes as $theme_data) {

          if ($theme_data['Stylesheet'] == $theme) {

              if (isset($theme_data['Status']) && $theme_data['Status'] != 'publish') {
                  return false;
              }
              return $theme_data;
          }
      }
      
      return false;
  }
  
  function esw_get_template($template)
  {
      $theme = esw_determine_theme();
      if ($theme === false) {
          return $template;
      }
      
      return $theme['Template'];
  }
  
  function esw_get_stylesheet($stylesheet)
  {
      $theme = esw_determine_theme();
      if ($theme === false) {
          return $stylesheet;
      }
      
      return $theme['Stylesheet'];
  }

//if(!empty($_SESSION['tema'])):
if(!empty($_COOKIE['tema'])):
 add_action('plugins_loaded','ESW_filters');
endif;

 function ESW_filters () {

    add_filter('template', 'esw_get_template');
    add_filter('stylesheet', 'esw_get_stylesheet');

 }
 
?>