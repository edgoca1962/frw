<?php

namespace WPFRW\Modules\Core;

use PHPMailer\PHPMailer\PHPMailer;
use WPFRW\Modules\Post\Post;
use WPFRW\Modules\Sae\Evento\Evento;
use WPFRW\Modules\Sae\Evento\EventoCF;

/**
 * 
 * Clase Core
 * 
 * @package WPFRW
 * 
 * Nota sobre Roles: 
 * sudo rm -rf node_modules package-lock.json
 */

class Core
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      require_once WPFRW_DIR_PATH . "/modules/core/walker.php";
      $this->atributos = [];
      $this->set_paginas();
      ThemeSetup::get_instance();
      Post::get_instance();
      GeneraCPT::get_instance();
      Evento::get_instance();
      EventoCF::get_instance();
      add_action('wp_ajax_nopriv_ingresar', [$this, 'ingresar']);
      add_action('wp_ajax_ingresar', [$this, 'ingresar']);
      add_action('wp_ajax_cambiar_clave', [$this, 'cambiar_clave']);
      add_action('after_setup_theme', [$this, 'crear_roles']);
      add_action('wp_ajax_agregar_usuario', [$this, 'agregar_usuario']);
      add_action('wp_ajax_modificar_usuario', [$this, 'modificar_usuario']);
      add_action('wp_ajax_eliminar_usuario', [$this, 'eliminar_usuario']);
      add_action('wp_ajax_validar_datos_usuario', [$this, 'validar_datos_usuario']);
      add_action('wp_ajax_galeria_imagenes', [$this, 'galeria_imagenes']);
      // add_action('phpmailer_init', [$this, 'smtpconfig']);
      add_action('wp_footer', [$this, 'auto_logout_script']);
      add_action('wp_ajax_force_logout', [$this, 'force_logout']);
   }
   public function set_atributo($parametro, $valor)
   {
      $this->atributos[$parametro] = $valor;
   }
   public function get_atributo($parametro)
   {
      return $this->atributos[$parametro];
   }
   public function get_atributos()
   {
      $datos = [];
      /************************************************************************
       * Establece el Tipo de Post
       ***********************************************************************/
      $PrefijoPage = '';
      $postType = get_post_type();
      if (isset($_GET['cpt'])) {
         $postType = sanitize_text_field($_GET['cpt']);
      } else {
         if (get_post_type() == 'page') {
            $PrefijoPage = substr(get_post(get_the_ID())->post_name, 0, strpos(get_post(get_the_ID())->post_name, '-'));
            if (isset(WPFRW_CPT_MODULO[$PrefijoPage])) {
               $postType = $PrefijoPage;
            }
         }
      }
      /************************************************************************
       * Parámetros de las clases del HTML
       ***********************************************************************/
      $datos['postType'] = $PrefijoPage;
      $datos['bs-theme'] = 'dark';
      $datos['html'] = '';
      $datos['body'] = '';
      $datos['header'] = '';
      $datos['div1'] = 'container-fluid py-5';
      $datos['div2'] = 'row';
      $datos['aside1'] = 'col-xl-2 d-flex justify-content-center';
      $datos['main'] = 'col-xl-8';
      $datos['div3'] = '';
      $datos['article'] = '';
      $datos['aside2'] = 'col-xl-2 d-flex justify-content-center';
      $datos['footer'] = 'container-fluid py-5';
      /************************************************************************
       * Parámetros para los Template Parts
       ***********************************************************************/
      $datos['t_banner'] = 'modules/core/view/core-banner';
      $datos['t_navbar'] = 'modules/core/view/core-navbar';
      $datos['t_aside1'] = 'modules/core/view/core-aside1';
      $datos['t_btnAgregar'] = '';
      $datos['t_btnRegresar'] = '';
      $datos['t_main'] = (is_page()) ? 'modules/core/view/' . get_post(get_the_ID())->post_name : '';
      $datos['t_comments'] = '/modules/core/view/core-comments';
      $datos['t_none'] = 'modules/core/view/core-none';
      $datos['t_aside2'] = 'modules/core/view/core-aside2';
      $datos['t_footer'] = 'modules/core/view/core-footer';
      $datos['t_btnRegresar'] = is_single() ? 'modules/core/view/core-btn-regresar' : '';
      $datos['t_busquedas'] = '';
      /************************************************************************
       * Parámetros para el Banner
       ***********************************************************************/
      $datos['imagen_banner'] = WPFRW_DIR_URI . '/assets/img/core/wpfrwbg.jpg';
      $datos['height'] = '80dvh';
      $datos['fontweight'] = 'fw-lighter';
      $datos['display'] = 'display-3';
      $datos['titulo'] = get_the_title();
      $datos['displaysub'] = 'display-4';
      $datos['subtitulo'] = '';
      $datos['displaysub2'] = 'display-5';
      $datos['subtitulo2'] = '';
      /************************************************************************
       * Parámetros para NavBar
       ***********************************************************************/
      $datos['logoSize'] = '80px';
      $datos['classLogo'] = '';
      $datos['navBarStyle'] = '';
      $datos['logo'] = $this->get_logo();
      /************************************************************************
       * Parámetros Generales
       ***********************************************************************/
      $datos['pag'] = $this->get_pags()['pag'];
      $datos['pag_ant'] = $this->get_pags()['pag_ant'];
      $datos['parametros'] = '';
      $datos['regresar'] = $postType;
      $datos['comentarios'] = true;
      $datos['admin'] = $this->get_facultades_usr()['admin'];
      $datos['post_abc'] = $this->get_facultades_usr()['post_abc'];
      $datos['post_status'] = $this->get_facultades_usr()['post_status'];
      $datos['post_view'] = $this->get_facultades_usr()['post_view'];
      $datos['roles'] = $this->get_roles_name();
      $datos['avatar'] = $this->get_avatar();


      $atributosModulos = $this->get_atributos_modulos($postType);
      $this->atributos = array_replace_recursive($datos, $atributosModulos);

      return $this->atributos;
   }
   private function get_atributos_modulos($postType)
   {
      $datos = [];
      switch ($postType) {
         case 'page':
            $datos = $this->get_atributos_page();
            break;

         case 'post':
            $datos = Post::get_instance()->get_atributos();
            break;

         case 'evento':
            $datos = Evento::get_instance()->get_atributos();
            break;

         default:
            $datos['titulo'] = 'Página no existe';
      }

      return $datos;
   }
   private function get_atributos_page()
   {
      $datos = [];
      if (is_page('core-login')) {
         if (!is_user_logged_in()) {
            /************************************************************************
             * Parámetros de las clases del HTML
             ***********************************************************************/
            $datos['div1'] = '';
            $datos['div2'] = '';
            $datos['aside1'] = '';
            $datos['main'] = '';
            $datos['aside2'] = '';
            $datos['footer'] = '';
            /************************************************************************
             * Parámetros para los Template Parts
             ***********************************************************************/
            $datos['t_banner'] = '';
            $datos['t_navbar'] = 'modules/core/view/core-navbar';
            $datos['t_aside1'] = '';
            $datos['t_main'] = 'modules/core/view/core-login';
            $datos['t_none'] = '';
            $datos['t_aside2'] = '';
            $datos['t_footer'] = '';
            /************************************************************************
             * Parámetros para Template core-login
             ***********************************************************************/
            $datos['imagen'] = (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : WPFRW_DIR_URI . '/assets/img/wpfrwbg.jpg';
            $datos['height'] = '100dvh';
            $datos['wplogo'] = (has_custom_logo()) ? wp_get_attachment_image_src(get_theme_mod('custom_logo'))[0] : WPFRW_DIR_URI . '/assets/img/wpfrwusr.png';
            $datos['redireccion'] = '/';
            $datos['logoSize'] = '50px';
            $datos['classLogo'] = 'rounded-circle';
         } else {
            $datos['titulo'] = 'Ya ingresó al sitio';
         }
      }
      return $datos;
   }
   private function set_paginas()
   {
      $paginas = [
         'cambio_clave' =>
         [
            'slug' => 'core-cambio-clave',
            'titulo' => 'Cambio de Contraseña'
         ],
         'login' =>
         [
            'slug' => 'core-login',
            'titulo' => 'Login'
         ],
         'usuario' =>
         [
            'slug' => 'core-usuario',
            'titulo' => 'Mantenimiento Usuario'
         ],
         'temporal' =>
         [
            'slug' => 'core-temporal',
            'titulo' => 'Temporal'
         ],
         'pruebas' =>
         [
            'slug' => 'core-pruebas',
            'titulo' => 'Pruebas'
         ],
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
   private function get_logo()
   {
      $datos = [];
      $logos = get_posts(['post_type' => 'attachment', 'post_name__in' => ['wpfrwlogonegro', 'wpfrwlogoblanco']]);
      foreach ($logos as $logo) {
         $datos[$logo->post_title] = $logo->guid;
      }
      return $datos;
   }
   public function ingresar()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'frm_ingreso')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $credenciales = array();
         $credenciales['user_login'] = $_POST['usuario'];
         $credenciales['user_password'] = $_POST['clave'];
         $credenciales['remember'] = true;
         $ingresar = wp_signon($credenciales, false);
         if (is_wp_error($ingresar)) {
            wp_send_json_error(['titulo' => 'Error', 'msg' => 'El usuario y la contraseña no coinciden.']);
         } else {
            wp_send_json_success(['titulo' => 'Ingreso', 'msg' => 'Se validaron las credenciales correctamente.']);
         }
      }
   }
   public function cambiar_clave()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'cambiar_clave')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {
         if (isset($_POST['clave_actual'])) {
            $clave_actual = sanitize_text_field($_POST['clave_actual']);
            $clave_nueva = sanitize_text_field($_POST['clave_nueva']);
            $clave_nueva2 = sanitize_text_field($_POST['clave_nueva2']);
            $user_id = get_current_user_id();
            $current_user = get_user_by('id', $user_id);
            if ($current_user && wp_check_password($clave_actual, $current_user->data->user_pass, $current_user->ID)) {
               if ($clave_nueva != $clave_nueva2) {
                  wp_send_json_error(['titulo' => 'Error', 'msg' => 'La Nueva Contraseña no coincide con su comprobación.']);
               } else {
                  wp_set_password($clave_nueva, $current_user->ID);
                  wp_send_json_success('Cambio clave exitoso');
               }
            } else {
               wp_send_json_error(['titulo' => 'Error', 'msg' => 'Contraseña Actual es incorrecta.']);
            }
         } else {
            wp_send_json_error(['titulo' => 'Error', 'msg' => 'Contraseña Actual no indicada']);
         }
      }
   }
   public function sae_evento_usuario()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'evento_usuario')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {
         $boton = sanitize_text_field($_POST['boton']);
         switch ($boton) {
            case 'validar_usr':
               $user_email = sanitize_text_field($_POST['user_email']);
               $datos = get_user_by('email', $user_email);
               if (empty($datos)) {
                  wp_send_json_success('agregar');
               } else {
                  $datos_usuario['ID'] = $datos->ID;
                  $datos_usuario['first_name'] = $datos->first_name;
                  $datos_usuario['last_name'] = $datos->last_name;
                  $datos_usuario['user_login'] = $datos->user_login;
                  $datos_usuario['user_pass'] = $datos->user_pass;
                  wp_send_json_success($datos_usuario);
               }
               break;
            case 'validar_login':
               $user_login = sanitize_text_field($_POST['user_login']);
               $datos = get_user_by('login', $user_login);
               if (empty($datos)) {
                  wp_send_json_success('agregar');
               } else {
                  $datos_usuario['ID'] = $datos->ID;
                  $datos_usuario['user_email'] = $datos->user_email;
                  $datos_usuario['user_login'] = $datos->user_login;
                  wp_send_json_success($datos_usuario);
               }
               break;
            case 'agregar_usuario':
               $user_email = sanitize_text_field($_POST['user_email']);
               $first_name = sanitize_text_field($_POST['first_name']);
               $last_name = sanitize_text_field($_POST['last_name']);
               $user_login = sanitize_text_field($_POST['user_login']);
               $user_pass = sanitize_text_field($_POST['user_pass']);
               $user_nicename = $first_name . '-' . $last_name;
               $nombre = $first_name . ' ' . $last_name;
               $userdata = array(
                  'user_pass' => $user_pass,
                  'user_login' => $user_login,
                  'user_nicename' => $user_nicename,
                  'user_email' => $user_email,
                  'display_name' => $nombre,
                  'nickname' => $user_login,
                  'first_name' => $first_name,
                  'last_name' => $last_name,
                  'show_admin_bar_front' => 'false'
               );
               $user_id = wp_insert_user($userdata);
               if (isset($_POST['saeadmin']) || isset($_POST['saecoord'])) {
                  $saeroles = new \WP_User($user_id);
                  // $saeroles->remove_role('subscriber');
                  if (isset($_POST['saeadmin'])) {
                     $saeroles->add_role('useradminevento');
                  } elseif (isset($_POST['saecoord'])) {
                     $saeroles->add_role('usercoordinaeventos');
                  }
               }
               wp_send_json_success(['titulo' => 'Usuario Registrado', 'msg' => 'El usuario fue registrado exitosamente.']);

               break;
            case 'modificar_usuario':
               $user_email = sanitize_text_field($_POST['user_email']);
               $first_name = sanitize_text_field($_POST['first_name']);
               $last_name = sanitize_text_field($_POST['last_name']);
               $user_login = sanitize_text_field($_POST['user_login']);
               $user_pass = sanitize_text_field($_POST['user_pass']);
               $user_nicename = $first_name . '-' . $last_name;
               $nombre = $first_name . ' ' . $last_name;

               $args = [
                  'user_email' => $user_email,
                  'first_name' => $first_name,
                  'last_name' => $last_name,
                  'user_login' => $user_login,
                  'user_pass' => $user_pass,
                  'user_nicename' => $user_nicename,
                  'display_name' => $nombre,

               ];
               wp_insert_user($args);
               wp_send_json_success(['titulo' => 'Usuario Modificado', 'msg' => 'El usuario fue modificado exitosamente.']);

               break;
            case 'eliminar_usuario':
               $user_id = $_POST['user_id'];
               wp_delete_user($user_id);
               wp_send_json_success(['titulo' => 'Usuario Eliminado', 'msg' => 'El usuario fue eliminado exitosamente.']);

               break;
         }
      }
   }
   public function crear_roles()
   {
      // update_option('evento_roles', false);
      if (!get_option('core_roles')) {
         add_role('useradmingeneral', 'Administrador(a) General', get_role('subscriber')->capabilities);
         update_option('core_roles', true);
         update_option('evento_roles', true);
      }
   }
   private function get_pags()
   {
      $pags = [];
      if (isset(explode("/", $_SERVER['REQUEST_URI'])[3])) {
         if (explode("/", $_SERVER['REQUEST_URI'])[3] != '') {
            if (explode("/", $_SERVER['REQUEST_URI'])[3] == 'page') {
               $pags['pag'] = 0; //explode("/", $_SERVER['REQUEST_URI'])[4];
            } else {
               $pags['pag'] = explode("/", $_SERVER['REQUEST_URI'])[3];
            }
         } else {
            $pags['pag'] = 0;
         }
      } else {
         $pags['pag'] = 1;
      }
      //incluir parámetro en el enlace del título del artículo.
      if (isset($_GET['pag'])) {
         $pags['pag_ant'] = sanitize_text_field($_GET['pag']);
         if ($pags['pag_ant'] == 0) {
            $pags['pag_ant'] = 1;
         }
      } else {
         $pags['pag_ant'] = 1;
      }
      // wp_die(print_r($pags['pag_ant']));
      return $pags;
   }
   private function get_facultades_usr()
   {
      if (current_user_can('administrator') || current_user_can('useradmingeneral')) {
         $datos['admin'] = true;
         $datos['post_abc'] = 'todos';
         $datos['post_status'] = 'publish';
         $datos['post_view'] = true;
      } else {
         $datos['admin'] = false;
         $datos['post_abc'] = '';
         $datos['post_status'] = 'draft';
         $datos['post_view'] = true;
      }

      return $datos;
   }
   private function get_roles_name()
   {
      $datos = [];
      $roles = wp_roles()->roles;
      foreach ($roles as $nombre => $valor) {
         if ($nombre == 'administrator' || $nombre == 'editor' || $nombre == 'author' || $nombre == 'contributor' || $nombre == 'subscriber') {
         } else {
            $datos[$nombre] = $valor['name'];
         }
      }
      return $datos;
   }
   public function agregar_usuario()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'core_usuario')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {
         $user_email = sanitize_text_field($_POST['user_email']);
         $first_name = sanitize_text_field($_POST['first_name']);
         $last_name = sanitize_text_field($_POST['last_name']);
         $user_login = sanitize_text_field($_POST['user_login']);
         $user_pass = sanitize_text_field($_POST['user_pass']);
         $user_nicename = $first_name . '-' . $last_name;
         $nombre = $first_name . ' ' . $last_name;

         $userdata = array(
            'user_pass' => $user_pass,
            'user_login' => $user_login,
            'user_nicename' => $user_nicename,
            'user_email' => $user_email,
            'display_name' => $nombre,
            'nickname' => $user_login,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'show_admin_bar_front' => 'false'
         );
         $user_id = wp_insert_user($userdata);

         // Lógica para Roles
         $user_obj = get_userdata($user_id);
         $roles = preg_grep('/^rol/', array_keys($_POST));

         if ($roles) {
            $user_obj->remove_role('subscriber');
            foreach ($roles as $rol) {
               $user_obj->add_role(sanitize_text_field($_POST[$rol]));
            }
         }

         // Lógica para imagen de Usuario
         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');

         $attach_id = media_handle_upload('usuario_imagen', 0);
         if (is_wp_error($attach_id)) {
            $attach_id = '';
         } else {
            update_user_meta($user_id, 'custom_avatar', $attach_id);
         }

         wp_send_json_success(['titulo' => 'Usuario Creado', 'msg' => 'El usuario fue creado exitosamente.', $roles]);
      }
   }
   public function modificar_usuario()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'core_usuario')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {

         $user_email = sanitize_text_field($_POST['user_email']);
         $first_name = sanitize_text_field($_POST['first_name']);
         $last_name = sanitize_text_field($_POST['last_name']);
         $user_login = sanitize_text_field($_POST['user_login']);
         $user_pass = sanitize_text_field($_POST['user_pass']);
         $user_nicename = $first_name . '-' . $last_name;
         $nombre = $first_name . ' ' . $last_name;
         $datos = get_user_by('email', $user_email);
         $args = [
            'ID' => $datos->ID,
            'user_email' => $user_email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_login' => $user_login,
            'user_pass' => $user_pass,
            'user_nicename' => $user_nicename,
            'display_name' => $nombre,

         ];
         wp_update_user($args);
         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');
         $attach_id = media_handle_upload('usuario_imagen', 0);
         if (is_wp_error($attach_id)) {
            $attach_id = '';
         } else {
            update_user_meta($datos->ID, 'custom_avatar', $attach_id);
         }

         $roles = preg_grep('/^rol_/', array_keys($_POST));
         foreach ($datos->roles as $rol) {
            $datos->remove_role($rol);
         }
         if ($roles) {
            foreach ($roles as $rol) {
               $datos->add_role(sanitize_text_field($_POST[$rol]));
            }
         } else {
            $datos->add_role('subscriber');
         }

         wp_send_json_success(['titulo' => 'Usuario Modificado', 'msg' => 'El usuario fue modificado exitosamente.']);
      }
   }
   public function eliminar_usuario()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'core_usuario')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {
         $user_email = sanitize_text_field($_POST['user_email']);
         $eliminar = get_user_by('email', $user_email)->ID;
         $reasignar = get_user_by('email', 'usuarios@borrados.com')->ID;
         wp_delete_user($eliminar, $reasignar);
         wp_send_json_success(['titulo' => 'Usuario Eliminado', 'msg' => 'El usuario fue eliminado exitosamente.']);
      }
   }
   public function validar_datos_usuario()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'core_usuario')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $validar = sanitize_text_field($_POST['validar']);
         global $wp_roles;
         switch ($validar) {
            case 'usuario':
               $user_email = sanitize_text_field($_POST['user_email']);
               $datos = get_user_by('email', $user_email);
               if (empty($datos)) {
                  wp_send_json_success('agregar');
               } else {
                  $datos_usuario['ID'] = $datos->ID;
                  $datos_usuario['first_name'] = $datos->first_name;
                  $datos_usuario['last_name'] = $datos->last_name;
                  $datos_usuario['user_login'] = $datos->user_login;
                  $datos_usuario['user_pass'] = $datos->user_pass;
                  $datos_roles = [];
                  if (!empty($datos->roles)) {
                     foreach ($datos->roles as $role_slug) {
                        $role_name = isset($wp_roles->roles[$role_slug]['name']) ? $wp_roles->roles[$role_slug]['name'] : $role_slug;
                        $datos_roles[$role_slug] = $role_name;
                     }
                  }

                  $datos_usuario['roles'] = $datos_roles;

                  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

                  $attach_id = media_handle_upload('usuario_imagen', 0);
                  if (is_wp_error($attach_id)) {
                     $attach_id = '';
                     if (get_user_meta($datos->ID, 'custom_avatar', true)) {
                        $datos_usuario['avatar'] = wp_get_attachment_url(get_user_meta($datos->ID, 'custom_avatar', true));
                     } else {
                        $datos_usuario['avatar'] = WPFRW_DIR_URI . '/assets/img/core/wpfrwusr.png';
                     }
                  } else {
                     update_user_meta($datos->ID, 'custom_avatar', $attach_id);
                     $datos_usuario['avatar'] = wp_get_attachment_url(get_user_meta($datos->ID, 'custom_avatar', true));
                  }
                  wp_send_json_success($datos_usuario);
               }
               break;
            case 'login':
               $user_login = sanitize_text_field($_POST['user_login']);
               $datos = get_user_by('login', $user_login);
               if (empty($datos)) {
                  wp_send_json_success('agregar');
               } else {
                  $datos_usuario['ID'] = $datos->ID;
                  $datos_usuario['user_email'] = $datos->user_email;
                  $datos_usuario['user_login'] = $datos->user_login;
                  wp_send_json_success($datos_usuario);
               }
               break;
         }
      }
   }
   private function get_avatar()
   {
      if (is_user_logged_in()) {
         if (wp_get_attachment_url(get_user_meta(get_current_user_id(), 'custom_avatar', true))) {
            $datos = wp_get_attachment_url(get_user_meta(get_current_user_id(), 'custom_avatar', true));
         } else {
            $datos = WPFRW_DIR_URI . '/assets/img/core/wpfrwusr.png';
         }
      } else {
         $datos = "";
      }
      return $datos;
   }
   public function get_f_tra($fecha, $formato)
   {
      /************************************************************************
      $formato = 'EEEE, d \'de\' MMMM \'de\' y'; // Ej: lunes, 5 de febrero de 2025
      $formato = 'd/M/y'; // Ej: 5/2/25
      $formato = 'dd-MM-yyyy'; // Ej: 05-02-2025
      $formato = 'y MMMM dd'; // Ej: 2025 febrero 05
      $formato = 'EEEE, d MMM y'; // Ej: lunes, 5 feb 2025
      $formato = 'EEEE d MMMM'; // Ej: lunes 5 febrero

      $formato = 'EEEE, d \'de\' MMMM \'de\' y'; // Ej: lunes, 5 de febrero de 2025
      $formato = 'd/M/y'; // Ej: 5/2/25
      $formato = 'dd-MM-yyyy'; // Ej: 05-02-2025
      $formato = 'y MMMM dd'; // Ej: 2025 febrero 05
      $formato = 'EEEE, d MMM y'; // Ej: lunes, 5 feb 2025
      $formato = 'EEEE d MMMM'; // Ej: lunes 5 febrero

      $formato = 'dd/MM/yy'; // Ej: 05/02/25
      $formato = 'yy-MM-dd'; // Ej: 25-02-05
      $formato = 'd MMM yy'; // Ej: 5 feb 25
      $formato = 'EEE, d MMM yy'; // Ej: lun, 5 feb 25
      $formato = 'hh:mm a dd/MM/yy'; // Ej: 02:30 p. m. 05/02/25

      $formato = 'HH:mm:ss'; // Ej: 14:30:15
      $formato = 'h:mm a'; // Ej: 2:30 p. m.
      $formato = 'HH:mm:ss zzzz'; // Ej: 14:30:15 Hora estándar de Europa central
      $formato = 'hh:mm:ss a z'; // Ej: 02:30:15 p. m. CET

      $formato = 'EEEE, d MMMM y HH:mm:ss'; // Ej: lunes, 5 febrero 2025 14:30:15
      $formato = 'dd/MM/yyyy hh:mm a'; // Ej: 05/02/2025 02:30 p. m.
      $formato = 'y-MM-dd HH:mm:ss'; // Ej: 2025-02-05 14:30:15
      $formato = 'EEE, d MMM y h:mm a'; // Ej: lun, 5 feb 2025 2:30 p. m.
       ************************************************************************/

      $fecha = new \DateTime($fecha);
      $formatter = new \IntlDateFormatter(
         'es_ES',
         \IntlDateFormatter::FULL,
         \IntlDateFormatter::FULL,
         null,
         \IntlDateFormatter::GREGORIAN,
         $formato
      );
      $fecha = esc_html(ucfirst($formatter->format($fecha)));
      return $fecha;
   }
   public function quitarDiacriticos($texto)
   {
      // Convierte los caracteres especiales en sus representaciones HTML
      $texto = htmlentities($texto, ENT_COMPAT, 'UTF-8');
      // Reemplaza los caracteres con acentos o diacríticos por su versión base
      $texto = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/', '$1', $texto);
      // Convierte las entidades HTML nuevamente en texto normal
      $texto = html_entity_decode($texto, ENT_COMPAT, 'UTF-8');
      // $texto = strtolower($texto);
      return $texto;
   }
   public function exportar_post_to_csv($postType)
   {
      global $wpdb;

      // Query posts from WordPress.
      $posts = $wpdb->get_results("SELECT post_title, post_content, post_date FROM {$wpdb->posts} WHERE post_type = $postType");

      // Define the CSV file path.
      $csv_file = plugin_dir_path(__FILE__) . 'exported-posts.csv';

      // Open the CSV file for writing.
      $csv_handle = fopen($csv_file, 'w');

      // Add headers to the CSV file.
      fputcsv($csv_handle, array('Post Title', 'Post Content', 'Post Date'));

      // Loop through the posts and write data to the CSV file.
      foreach ($posts as $post) {
         $data = array(
            $post->post_title,
            $post->post_content,
            $post->post_date
         );
         fputcsv($csv_handle, $data);
      }

      // Close the CSV file.
      fclose($csv_handle);

      // Provide a download link for the CSV file.
      header('Content-Type: text/csv');
      header('Content-Disposition: attachment; filename="exported-posts.csv"');
      readfile($csv_file);
      exit;
   }
   private function get_browser_name($user_agent)
   {
      if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
      elseif (strpos($user_agent, 'Edge')) return 'Edge';
      elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
      elseif (strpos($user_agent, 'Safari')) return 'Safari';
      elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
      elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';

      return 'Other';
   }
   public function sca_send_email()
   {
      if (!wp_verify_nonce($_POST['nonce_email'], 'send_email')) {
         wp_send_json_error('Error de seguridad', 401);
         die();
      }
      if (isset($_POST['enlace'])) {
         $enlace = sanitize_text_field($_POST['enlace']);
      } else {
         $enlace = '';
      }
      if (isset($_POST['titulo'])) {
         $titulo = sanitize_text_field($_POST['titulo']);
      } else {
         $titulo = '';
      }
      if (isset($_POST['estatus'])) {
         $estatus = sanitize_text_field($_POST['estatus']);
      } else {
         $estatus = '';
      }
      if (isset($_POST['origen'])) {
         $origen = sanitize_text_field($_POST['origen']);
      } else {
         $origen = '';
      }
      if (isset($_POST['enviar_a'])) {
         $enviar_a = sanitize_text_field($_POST['enviar_a']);
      } else {
         $enviar_a = '';
      }
      if (isset($_POST['enviar_a_nombre'])) {
         $enviar_a_nombre = sanitize_text_field($_POST['enviar_a_nombre']);
      } else {
         $enviar_a_nombre = '';
      }
      if (isset($_POST['mensaje'])) {
         $mensaje_no_vencido = sanitize_textarea_field($_POST['mensaje']);
      } else {
         $mensaje_no_vencido = '';
      }
      if (isset($_POST['con_copia'])) {
         $con_copia = sanitize_text_field($_POST['con_copia']);
      } else {
         $con_copia = '';
      }
      if (isset($_POST['con_copia_nombre'])) {
         $con_copia_nombre = sanitize_text_field($_POST['con_copia_nombre']);
      } else {
         $con_copia_nombre = '';
      }
      //Who is sending the email?
      // $admin_email = get_option('admin_email');
      $admin_email = sanitize_text_field($_POST['enviado_por']);
      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      $headers[] = 'From: Administración Acuerdos: <' . $admin_email . '>';
      $headers[] = 'Replay-to: ' . $admin_email;
      $headers[] = 'CC: ' . $con_copia_nombre . '<' . $con_copia . '>';
      $send_to = $enviar_a;
      $subject = $titulo;
      $mensaje = '';
      if ($estatus == 'Vencido') {
         $mensaje .= 'Bendiciones, ' . $enviar_a_nombre . ':<br><br>';
         $mensaje .= "El siguiente acuerdo asignado a su persona está vencido y le agradeceríamos nos indique si éste ya fue atendido. En caso de ser así, por favor, envíenos la evidencia al correo <strong>$admin_email</strong>. Sino, le agradeceríamos que nos indique cuál sería la nueva fecha de compromiso.<br><br>";
         $mensaje .= '<strong>Acuerdo vencido:</strong> <a href="' . $enlace . '" >' . $titulo . '</a><br><br>';
         $mensaje .= 'Quedamos a su disposición para cualquier aclaración adicional al respecto.<br><br>';
         $mensaje .= 'Saludos cordiales.';
      } else {
         $mensaje .=  $mensaje_no_vencido;
      }
      try {
         if (wp_mail($send_to, $subject, $mensaje, $headers)) {
            wp_send_json_success(['titulo' => 'e-mail', 'msg' => 'El e-mail se envió correctamente.']);
         } else {
            $mensaje = 'El aviso de acuerdo vencido no pudo ser enviado  al correo ' . $send_to;
            wp_send_json_error(['titulo' => 'e-mail Error', 'msg' => $mensaje]);
         }
      } catch (\Exception $e) {
         wp_send_json_error($e->getMessage());
      }
   }
   public function smtpconfig(PHPMailer $phpmailer)
   {
      $phpmailer->isSMTP();
      $phpmailer->Host       = 'smtp.hostinger.com';
      $phpmailer->SMTPAuth   = true;
      $phpmailer->Port       = 587;
      $phpmailer->Username   = 'soporte@fgh-org.org';
      $phpmailer->Password   = 'Fagohi<1986Edgoca>1962';
      $phpmailer->SMTPSecure = 'tls';
      $phpmailer->From       = 'soporte@fgh-org.org';
      $phpmailer->FromName   = 'Soporte';
   }
   public function galeria_imagenes()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'galeria_imagenes')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {

         wp_send_json_success(['titulo' => 'Imágenes Guardadas', 'msg' => 'Todas las imágenes fueron guardas exitosamente.']);
      }
   }
   public function get_tipo_cambio($codigo, $f_inicio, $f_final)
   {
      $url = "https://gee.bccr.fi.cr/Indicadores/Suscripciones/WS/wsindicadoreseconomicos.asmx?WSDL";
      $indicador = $codigo; // 317 = Compra, 318 = Venta
      $fechaInicio = $f_inicio;
      $fechaFin = $f_final;
      $usuario = "Edwin González";
      $subniveles = "N";
      $email = "edgoca1962@hotmail.com";
      $token = "DAS5ENLO1W";
      try {
         $client = new \SoapClient($url, ['trace' => 1]);
         $params = [
            "Indicador" => $indicador,
            "FechaInicio" => $fechaInicio,
            "FechaFinal" => $fechaFin,
            "Nombre" => $usuario,
            "SubNiveles" => $subniveles,
            "CorreoElectronico" => $email,
            "Token" => $token
         ];
         $response = $client->ObtenerIndicadoresEconomicosXML($params);
         $xml = simplexml_load_string($response->ObtenerIndicadoresEconomicosXMLResult);
         $datos = [];
         foreach ($xml->INGC011_CAT_INDICADORECONOMIC as $dato) {
            $datos[] = [
               'codigo' => (string) $dato->COD_INDICADORINTERNO,
               'fecha'  => (string) $dato->DES_FECHA,
               'valor'  => (float) $dato->NUM_VALOR,
            ];
         }
         return  $datos;
      } catch (\Exception $e) {
         echo "Error al obtener la tasa: " . $e->getMessage();
      }
   }
   public function auto_logout_script()
   {
      if (is_user_logged_in()) {
         $ajax_url = esc_url(admin_url('admin-ajax.php'));

?>
         <script>
            (function() {
               let logoutTime = 30 * 60 * 1000;
               let timeout;

               function resetTimer() {
                  clearTimeout(timeout);
                  timeout = setTimeout(logoutUser, logoutTime);
               }

               function logoutUser() {
                  fetch("<?php echo $ajax_url; ?>", {
                     method: "POST",
                     headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                     },
                     body: "action=force_logout"
                  }).then(() => {
                     window.location.href = "<?php echo esc_url(site_url('/')); ?>";
                  });
               }

               ["mousemove", "keydown", "scroll", "click"].forEach(event =>
                  document.addEventListener(event, resetTimer)
               );

               resetTimer();
            })();
         </script>
<?php
      }
   }
   public function force_logout()
   {
      wp_logout();
      wp_send_json_success();
   }
}
