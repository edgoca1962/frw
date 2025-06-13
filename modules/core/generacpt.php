<?php

namespace WPFRW\Modules\Core;

/**
 * 
 * Clase para la creación de CPT
 * 
 * @package: WPFRW
 * 
 */

class GeneraCPT
{
   use Singleton;

   private $atributos;

   function __construct()
   {
      $this->atributos =
         [
            'evento' => [
               "plural" => "eventos",
               "icon"   => "dashicons-book",
               "taxonomies" => ['evento_cat', 'evento_tag']
            ],
            'inscripcion' => [
               "plural" => "inscripciones",
               "icon"   => "dashicons-book",
               "taxonomies" => []
            ],
         ];

      add_action('init', [$this, 'add_custom_post_types']);
      add_action('init', [$this, 'registrar_todas_las_taxonomias']);
   }
   public function set_atributo($parametro, $valor)
   {
      $this->atributos[$parametro] = $valor;
   }
   public function get_atributo($parametro)
   {
      return $this->atributos[$parametro];
   }
   function add_custom_post_types()
   {
      foreach ($this->atributos as $type => $data) {

         $labels = array(
            'name'                  => _x(ucfirst($type), 'Post Type General Name', 'WPFRW'),
            'singular_name'         => _x(ucfirst($type), 'Post Type Singular Name', 'WPFRW'),
            'menu_name'             => __(ucfirst($data['plural']), 'WPFRW'),
            'name_admin_bar'        => __(ucfirst($data['plural']), 'WPFRW'),
            'add_new'               => __('Agregar', 'WPFRW'),
            'add_new_item'          => __('Agregar nuevo(a)', 'WPFRW'),
            'new_item'              => __('Nuevo(a)', 'WPFRW'),
            'edit_item'             => __('Editar', 'WPFRW'),
            'update_item'           => __('Actualizar', 'WPFRW'),
            'view_item'             => __('Ver ' . $type, 'WPFRW'),
            'view_items'            => __('Ver ' . $data['plural'], 'WPFRW'),
            'all_items'             => __('Todos(as)', 'WPFRW'),
            'search_items'          => __('Buscar ' . $type, 'WPFRW'),
            'parent_item_colon'     => __(ucfirst($data['plural']) . ' padre:', 'WPFRW'),
            'not_found'             => __("No hay $type", 'WPFRW'),
            'not_found_in_trash'    => __("No hay $type", 'WPFRW'),
            'archives'              => __('Archivo ' . $data['plural'], 'WPFRW'),
            'attributes'            => __('Atributos ' . $type, 'WPFRW'),
            'insert_into_item'      => __('Insertar ' . $type, 'WPFRW'),
            'uploaded_to_this_item' => __('Subir ' . $type, 'WPFRW'),
            'items_list'            => __('Lista ' . $type, 'WPFRW'),
            'items_list_navigation' => __('Navegación ' . $data['plural'], 'WPFRW'),
            'filter_items_list'     => __('Filtro ' . $data['plural'], 'WPFRW'),
         );

         $rewrite = array(
            'slug'       => $type,
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
         );

         $args = array(
            'label'               => __(ucfirst($type), 'WPFRW'),
            'description'         => __('Contenido de ' . ucfirst($data['plural']), 'WPFRW'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats'),
            'taxonomies'          => [],
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => $data['icon'],
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => $rewrite,
            'capability_type'     => [$type, $data['plural']],
            'map_meta_cap'        => true,
            'show_in_rest'        => true,
            'rest_base'           => $data['plural'],

         );

         register_post_type($type, $args);

         $admin = get_role('administrator');
         $capabilities = $this->get_capacidades($type, $data['plural']);
         foreach ($capabilities as $capability) {
            if (!$admin->has_cap($capability)) {
               $admin->add_cap($capability);
            }
         }
      }
      flush_rewrite_rules();
   }
   private function get_capacidades($singular, $plural)
   {
      $capacidades = [
         'edit_post' => "edit_$singular",
         'read_post' => "read_$singular",
         'delete_post' => "delete_$singular",
         'edit_posts' => "edit_$plural",
         'edit_others_posts' => "edit_others_$plural",
         'publish_posts' => "publish_$plural",
         'read_private_posts' => "read_private_$plural",
         'read' => "read",
         'delete_posts' => "delete_$plural",
         'delete_private_posts' => "delete_private_$plural",
         'delete_published_posts' => "delete_published_$plural",
         'delete_others_posts' => "delete_others_$plural",
         'edit_private_posts' => "edit_private_$plural",
         'edit_published_posts' => "edit_published_$plural",
         'create_posts' => "edit_$plural",
      ];
      return $capacidades;
   }
   public function registrar_todas_las_taxonomias()
   {
      foreach ($this->atributos as $type => $data) {
         if (!empty($data['taxonomies'])) {
            foreach ($data['taxonomies'] as $taxonomy) {
               $this->registrar_taxonomia($taxonomy, $type, $data['plural']);
            }
         }
      }
   }
   public function registrar_taxonomia($taxonomy, $post_type, $plural_name)
   {
      $tip_tax = substr($taxonomy, -3);
      if ($tip_tax === 'cat') {
         $categoria = true;
         $name = 'Categorías';
         $singular_name = 'Categoría de ' . ucfirst($post_type);
         $item_singular = 'Categoría';
         $item_plural = 'Categorías';
      } else {
         $categoria = false;
         $name = 'Etiquetas';
         $singular_name = 'Etiqueta de ' . ucfirst($post_type);
         $item_singular = 'Etiqueta';
         $item_plural = 'Etiquetas';
      }
      // Argumentos para la taxonomía
      $args = [
         'labels' => [
            'name'                       => __($name, 'WPFRW'),
            'singular_name'              => __($singular_name, 'WPFRW'),
            'menu_name'                  => __($name, 'WPFRW'),
            'all_items'                  => __("Todas las $item_plural", 'WPFRW'),
            'edit_item'                  => __("Editar $item_singular", 'WPFRW'),
            'view_item'                  => __("Ver $item_singular", 'WPFRW'),
            'update_item'                => __("Actualizar $item_singular", 'WPFRW'),
            'add_new_item'               => __("Añadir Nueva $item_singular", 'WPFRW'),
            'new_item_name'              => __("Nombre de la Nueva $item_singular", 'WPFRW'),
            'parent_item'                => __("$item_singular Padre", 'WPFRW'),
            'parent_item_colon'          => __("$item_singular Padre:", 'WPFRW'),
            'search_items'               => __("Buscar $item_plural", 'WPFRW'),
            'popular_items'              => __("$item_plural Populares", 'WPFRW'),
            'separate_items_with_commas' => __("Separar $item_plural con comas", 'WPFRW'),
            'add_or_remove_items'        => __("Añadir o eliminar $item_plural", 'WPFRW'),
            'choose_from_most_used'      => __('Escoger de las más utilizadas', 'WPFRW'),
            'not_found'                  => __("No se encontraron $item_plural", 'WPFRW'),
         ],
         'hierarchical'          => ($categoria) ? true : false, // true para comportarse como categorías
         'show_in_nav_menus'     => true,
         'show_ui'               => true,
         'show_admin_column'     => true,
         'rewrite'               => ['slug' => $taxonomy],
         'show_in_rest'          => true, // Mostrar en la REST API
         'rest_base'             => $taxonomy, // Ruta base para la REST API
      ];

      // Registrar la taxonomía
      register_taxonomy($taxonomy, [$post_type], $args);
   }
}
