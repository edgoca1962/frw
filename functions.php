<?php


/**
 * Functions Theme
 * 
 * @package WPFRW
 * 
 */

use WPFRW\Modules\Core\Core;

if (!defined('WPFRW_DIR_PATH')) {
   define('WPFRW_DIR_PATH', untrailingslashit(get_template_directory()));
}
if (!defined('WPFRW_DIR_STYLE')) {
   define('WPFRW_DIR_STYLE', untrailingslashit(get_stylesheet_uri()));
}
if (!defined('WPFRW_DIR_URI')) {
   define('WPFRW_DIR_URI', untrailingslashit(get_template_directory_uri()));
}
if (!defined('WPFRW_POST_THUMBNAIL_URI')) {
   define('WPFRW_POST_THUMBNAIL_URI', untrailingslashit(get_the_post_thumbnail_url()));
}
if (!defined('WPFRW_MODULOS')) {
   define('WPFRW_MODULOS', ['sae']); //Para Directorios de Módulos con varios CPT
}
if (!defined('WPFRW_CPT_MODULO')) {
   define('WPFRW_CPT_MODULO', ['post' => 'post', 'evento' => 'sae']);
}


require_once WPFRW_DIR_PATH . '/modules/core/autoloader.php';

if (!function_exists('WPFRW_get_theme_instance')) {
   function WPFRW_get_theme_instance()
   {
      Core::get_instance();
   }
   WPFRW_get_theme_instance();
}
