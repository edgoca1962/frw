<?php

namespace WPFRW\Modules\Post;

use WPFRW\Modules\Core\Singleton;

/**
 * 
 * Clase Post
 * 
 * @package WPFRW
 * 
 */

class Post
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = [];
      $this->set_paginas();
      $this->crear_roles();
      add_action('wp_ajax_editar_post', [$this, 'editar_post']);
      add_action('wp_ajax_eliminar_post', [$this, 'eliminar_post']);
   }
   public function set_atributo($parametro, $valor)
   {
      $this->atributos[$parametro] = $valor;
   }
   public function get_atributo($parametro)
   {
      return $this->atributos[$parametro];
   }
   public function get_atributos($postType = 'post')
   {
      $datos = [];
      /************************************************************************
       * Parámetros de las clases del HTML
       ***********************************************************************/
      $datos['div1'] = 'container py-5';
      $datos['aside1'] = 'col-sm-6 col-md-3 col-xl-3';
      $datos['main'] = 'col-sm-6 col-md-9 col-xl-9';
      /************************************************************************
       * Parámetros para los Template Parts
       ***********************************************************************/
      $datos['t_aside1'] = "modules/$postType/view/$postType-aside1";
      $datos['t_btnAgregar'] = ($this->get_facultades_usr()['post_abc']) ? "modules/$postType/view/$postType-btn-agregar" : '';
      $datos['t_main'] = '';
      $datos['t_none'] = '';
      $datos['t_aside2'] = '';
      $datos['t_footer'] = "modules/$postType/view/$postType-footer";
      $datos['t_busquedas'] = "modules/$postType/view/$postType-busquedas";
      /************************************************************************
       * Parámetros para el Banner
       ***********************************************************************/
      $datos['imagen_banner'] = (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : WPFRW_DIR_URI . '/assets/img/post/postbg.jpg';
      $datos['titulo'] = 'Blog';
      /************************************************************************
       * Parámetros para el Blog
       ***********************************************************************/
      $datos['admin'] = $this->get_facultades_usr()['admin'];
      $datos['post_abc'] = $this->get_facultades_usr()['post_abc'];
      $datos['post_status'] = $this->get_facultades_usr()['post_status'];
      $datos['post_view'] = $this->get_facultades_usr()['post_view'];

      $datos['imagen'] = (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : WPFRW_DIR_URI . '/assets/img/post/post.jpg';
      $datos['categorias'] = $this->get_categorias();
      $datos['etiquetas'] = $this->get_etiquetas();

      if (is_single()) {
         $datos['t_main'] = "modules/$postType/view/$postType-single";
         $datos['subtitulo'] = get_the_title();
      } else {
         if (is_page()) {
            $datos['t_main'] = "modules/$postType/view/" . get_post(get_the_ID())->post_name;
            $datos['titulo'] = get_the_title();
         } else {
            $datos['t_main'] = "modules/$postType/view/$postType";
            $datos['article'] = 'row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 pb-5';
         }
      }

      return $this->atributos = $datos;
   }
   public function crear_roles()
   {
      // update_option('post_roles', false);
      if (!get_option('post_roles')) {
         add_role('posteditor', 'Editor de Blog', get_role('subscriber')->capabilities);
         add_role('postautor', 'Autor de Blog', get_role('subscriber')->capabilities);
         add_role('postcolaborador', 'Colaborador de Blog', get_role('subscriber')->capabilities);
         update_option('post_roles', true);
      }
   }
   private function get_facultades_usr()
   {
      /**********************************************************************************
       * 
       * Suscriber público en general.
       * [post]Colaborador: puede abc de sus posts del tipo de post pero no se publican.
       * [post]Autor: puede abc de sus posts del tipo de post y se publican.
       * [post]Editor: puede abc sobre todos los posts del tipo de posts y se publican.
       * 
       **********************************************************************************/

      if (current_user_can('administrator') || current_user_can('useradmingeneral')) {
         $datos['admin'] = true;
         $datos['post_abc'] = 'todos';
         $datos['post_status'] = 'publish';
         $datos['post_view'] = true;
      } elseif (current_user_can('posteditor')) {
         $datos['admin'] = false;
         $datos['post_abc'] = 'todos';
         $datos['post_status'] = 'publish';
         $datos['post_view'] = true;
      } elseif (current_user_can('postautor') || current_user_can('postcolaborador')) {
         $datos['admin'] = false;
         $datos['post_abc'] = 'propios';
         $datos['post_status'] = (current_user_can('postcolaborador')) ? 'draft' : 'publish';
         $datos['post_view'] = true;
      } else {
         $datos['admin'] = false;
         $datos['post_abc'] = '';
         $datos['post_status'] = '';
         $datos['post_view'] = true;
      }
      return $datos;
   }
   private function get_post_view()
   {
      $datos['body'] = 'container py-5';
      $dastos['div1'] = '';
      $datos['post_view'] = (is_front_page()) ? true : false;
      if (!$datos['post_view']) {
         wp_redirect(site_url('/'));
      }

      return $datos;
   }
   private function get_categorias()
   {
      $datos = [];
      $categorias = wp_get_post_terms(get_the_ID(), 'category', ['exclude' => 1]);
      foreach ($categorias as $categoria) {
         $datos[] = ['enlace' => get_term_link($categoria->term_id), 'nombre' => $categoria->name];
      }
      return $datos;
   }
   private function get_etiquetas()
   {
      $datos = [];
      $categorias = wp_get_post_terms(get_the_ID(), 'post_tag');
      foreach ($categorias as $categoria) {
         $datos[] = ['enlace' => get_term_link($categoria->term_id), 'nombre' => $categoria->name];
      }
      return $datos;
   }
   private function set_paginas()
   {
      $paginas = [
         'post_agregar' =>
         [
            'slug' => 'post-agregar',
            'titulo' => 'Agregar Post'
         ]
      ];
      foreach ($paginas as $pagina) {
         $pags = get_posts([
            'post_type' => 'page',
            'post_status' => 'publish',
            'name' => $pagina['slug'],
         ]);
         if (count($pags) > 0) {
         } else {
            $post_data = array(
               'post_type' => 'page',
               'post_title' => $pagina['titulo'],
               'post_name' => $pagina['slug'],
               'post_status' => 'publish',
            );
            wp_insert_post($post_data);
         }
      }
   }
   public function editar_post()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'post_abc')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {
         wp_send_json_success(['titulo' => 'Artículo Editado', 'msg' => 'El Artículo se editó exitosamente.']);
      }
   }
   public function eliminar_post()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'post_abc')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {
         wp_send_json_success(['titulo' => 'Artículo Eliminado', 'msg' => 'El Artículo se eliminó exitosamente.']);
      }
   }
}
