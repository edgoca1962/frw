<?php

namespace WPFRW\Modules\Core;

use WPFRW\Modules\Core\Singleton;

/**
 * 
 * clase configuración WP theme.
 * @package: WPFRW
 * 
 */


class ThemeSetup
{
   use Singleton;
   private function __construct()
   {
      add_action('after_setup_theme', [$this, 'WPFRW_theme_functionality']);
      add_action('wp_enqueue_scripts', [$this, 'WPFRW_register_scripts_styles']);
   }
   public function WPFRW_theme_functionality()
   {
      load_theme_textdomain('WPFRW', get_template_directory() . '/languages');
      add_theme_support('title-tag');
      add_theme_support('automatic-feed-links');
      add_theme_support('post-thumbnails');
      add_theme_support('post-formats', array('aside', 'gallery', 'quote', 'image', 'video'));
      add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
      add_theme_support('customize-selective-refresh-widgets');
      add_theme_support('wp-block-styles');
      add_theme_support('block-templates');
      add_theme_support('align-wide');
      add_theme_support('custom-logo', array('height' => 300, 'width' => 300, 'flex-width' => true, 'flex-height' => true,));
      register_nav_menus(
         array(
            'principal' => __('Menu Principal', 'WPFRW'),
            'administrador' => __('Menu Administrador', 'WPFRW'),
         )
      );

      add_role('useradmingeneral', 'Administrador(a) General', get_role('subscriber')->capabilities);
   }
   public function WPFRW_register_scripts_styles()
   {
      wp_enqueue_style('styles', WPFRW_DIR_STYLE, array(), null, 'all');
      wp_enqueue_script('scripts', WPFRW_DIR_URI . '/assets/main.js', array('jquery'), null, true);

      wp_localize_script('scripts', 'serverTimezoneData', array(
         'serverTimezone' => get_option('timezone_string'),
         'serverOffset'   => get_option('gmt_offset') * 3600,
      ));
   }
}
