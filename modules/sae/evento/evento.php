<?php

namespace WPFRW\Modules\Sae\Evento;

use WPFRW\Modules\Core\Singleton;

/**
 * 
 * Clase Evento
 * 
 * @package WPFRW
 * 
 */

class Evento
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = $this->get_atributos();
      $this->crear_roles();
      $this->set_paginas();
      add_action('pre_get_posts', [$this, 'pre_get_posts_eventos']);
      add_action('init', [$this, 'set_fpe']);
      add_action('wp_ajax_registrar_evento', [$this, 'registrar_evento']);
      add_action('wp_ajax_eliminar_evento', [$this, 'eliminar_evento']);
   }
   public function set_atributo($parametro, $valor)
   {
      $this->atributos[$parametro] = $valor;
   }
   public function get_atributo($parametro)
   {
      return $this->atributos[$parametro];
   }
   public function get_atributos($postType = 'evento')
   {
      $datos = [];
      $datos = $this->get_calendario();
      /************************************************************************
       * Parámetros de las clases del HTML
       ***********************************************************************/
      $datos['div1'] = 'container py-5';
      $datos['aside1'] = 'col-12 col-lg-12 col-xl-3 d-flex justify-content-lg-center';
      $datos['main'] = 'col-12 col-lg-12 col-xl-9';
      /************************************************************************
       * Parámetros para los Template Parts
       ***********************************************************************/
      $datos['t_aside1'] = "modules/sae/$postType/view/$postType-aside1";
      $datos['t_btnAgregar'] = ($this->get_facultades_usr()['admin'] && !is_page()) ? "modules/sae/$postType/view/$postType-btn-agregar" : '';
      $datos['t_main'] = '';
      $datos['t_none'] = '';
      $datos['t_aside2'] = '';
      $datos['t_footer'] = "modules/sae/$postType/view/$postType-footer";
      $datos['t_busquedas'] = "modules/sae/$postType/view/$postType-busquedas";
      /************************************************************************
       * Parámetros para el Banner
       ***********************************************************************/
      $datos['imagen_banner'] = WPFRW_DIR_URI . '/assets/img/sae/eventosbanner.jpg';
      $datos['titulo'] = 'Eventos';
      /************************************************************************
       * Parámetros para Eventos
       ***********************************************************************/
      $datos['admin'] = $this->get_facultades_usr()['admin'];
      $datos['post_abc'] = $this->get_facultades_usr()['post_abc'];
      $datos['post_status'] = $this->get_facultades_usr()['post_status'];
      $datos['post_view'] = $this->get_facultades_usr()['post_view'];
      $datos['imagen'] = (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : WPFRW_DIR_URI . '/assets/img/sae/eventos.jpg';
      $datos['comentarios'] = false;
      $datos['categorias'] = $this->get_categorias();
      $datos['etiquetas'] = $this->get_etiquetas();

      $datos['evento_diario'] = $this->t_tipEvento($postType)['evento_diario'];
      $datos['evento_semanal'] = $this->t_tipEvento($postType)['evento_semanal'];
      $datos['evento_mensual'] = $this->t_tipEvento($postType)['evento_mensual'];
      $datos['evento_anual'] = $this->t_tipEvento($postType)['evento_anual'];
      $datos['evento_cambiar_horario'] = "modules/sae/$postType/view/$postType-cambiar-horario";
      $datos['evento_categoria'] = "modules/sae/$postType/view/$postType-categoria";
      $datos['evento_calendario'] = "modules/sae/$postType/view/$postType-calendario";
      $datos['recurrencia'] = isset($_GET['recurrencia']) ? sanitize_text_field($_GET['recurrencia']) : '6';
      $datos['f_cancelada'] = $this->get_f_cancelada(get_the_ID());
      $datos['diaordinal'] = ['1' => 'first', '2' => 'second', '3' => 'third', '4' => 'fourth', '5' => 'last'];
      $datos['diasemana'] = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday'];
      $datos['roles_eventos'] = $this->get_roles_eventos();


      if (is_single()) {
         $datos['t_main'] = "modules/sae/$postType/view/$postType-single";
         if (isset($_GET['fpe'])) {
            $datos['subtitulo'] = $this->get_f_tra(date('Y-m-d', strtotime($_GET['fpe'])), 'EEEE, d MMMM yyyy');
         } else {
            $datos['subtitulo'] = $this->get_f_tra(date('Y-m-d', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true))), 'EEEE, d MMMM yyyy');
         }
         $datos['subtitulo2'] = get_the_title();
      } else {
         if (is_page()) {
            $datos['t_main'] = "modules/sae/$postType/view/" . get_post(get_the_ID())->post_name;
            $datos['titulo'] = get_the_title();
         } else {
            $datos['t_main'] = "modules/sae/$postType/view/$postType";
            $datos['article'] = 'row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 pb-5';
            if (isset($_GET['fpe'])) {
               $datos['subtitulo'] = $this->get_f_tra(date('Y-m-d', strtotime(sanitize_text_field($_GET['fpe']))), 'EEEE, d MMMM yyyy');
            } elseif (isset($_GET['mes']) && isset($_GET['anno'])) {
               $fecha = sanitize_text_field($_GET['mes']) . ' ' . sanitize_text_field($_GET['anno']);
               $datos['subtitulo'] = $this->get_f_tra(date('Y-m-d', strtotime($fecha)), 'MMMM yyyy');
            } else {
               $datos['subtitulo'] = $this->get_f_tra(date('Y-m-d'), 'MMMM yyyy');
               // $datos['subtitulo'] = $this->get_atributo('monthName')[$datos['mes']] . ' del ' . $datos['anno'];
            }
         }
      }

      return $this->atributos = $datos;
   }
   public function pre_get_posts_eventos($query)
   {
      if ($query->is_main_query() && !is_admin()) {
         if (is_post_type_archive('evento')) {

            if (isset($_GET['recurrencia'])) {
               $recurrencia = sanitize_text_field($_GET['recurrencia']);
               if ($recurrencia == '6') {
                  $recurrencia = '';
                  $comparar = '!=';
               } else {
                  $recurrencia = $recurrencia;
                  $comparar = '=';
               }
            } else {
               $recurrencia = '';
               $comparar = '!=';
            }

            if (isset($_GET['mes']) && isset($_GET['anno'])) {
               $mes = sanitize_text_field($_GET['mes']);
               $anno = sanitize_text_field($_GET['anno']);
               $f_inicio = date('Y-m-d H:i:s', strtotime('first day of ' . $mes . ' ' . $anno));
               $f_final = date('Y-m-d H:i:s', strtotime('last day of ' . $mes . ' ' . $anno));
               $f_final = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($f_final)) . ' 23:59:59'));
            } else {
               $f_inicio = date('Y-m-d H:i:s', strtotime('first day of ' . date('F') . ' ' . date('Y')));
               $f_final = date('Y-m-d H:i:s', strtotime('last day of ' . date('F') . ' ' . date('Y')));
               $f_final = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($f_final)) . ' 23:59:59'));
            }
            if (isset($_GET['fpe'])) {
               $fecha =  sanitize_text_field(($_GET['fpe']));
               $f_inicio = date('Y-m-d H:i:s', strtotime($fecha));
               $f_final = date('Y-m-d 24:00:00', strtotime($fecha));
            }
            $meta_query =
               [
                  [
                     'key' => '_f_proxevento',
                     'value' => [$f_inicio, $f_final],
                     'compare' => 'BETWEEN'
                  ],
                  [
                     'key' => '_periodicidadevento',
                     'value' => $recurrencia,
                     'compare' => $comparar
                  ]
               ];

            $query->set('post_status', ['publish', 'private']);
            $query->set('meta_query', $meta_query);
            $query->set('posts_per_page', 9);
            $query->set('meta_key', '_f_proxevento');
            $query->set('orderby', 'meta_value');
            $query->set('order', 'ASC');
         }
      }
   }
   private function set_paginas()
   {
      $paginas = [
         'agregar' =>
         [
            'slug' => 'evento-agregar',
            'titulo' => 'Agregar Eventos'
         ],
         'pruebas' =>
         [
            'slug' => 'evento-pruebas',
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
   public function sae_pre_get_posts_eventos($query)
   {
      if ($query->is_main_query() && !is_admin()) {
         if (is_post_type_archive('evento')) {

            if (isset($_GET['recurrencia'])) {
               $recurrencia = sanitize_text_field($_GET['recurrencia']);
               if ($recurrencia == '6') {
                  $recurrencia = '';
                  $comparar = '!=';
               } else {
                  $recurrencia = $recurrencia;
                  $comparar = '=';
               }
            } else {
               $recurrencia = '';
               $comparar = '!=';
            }

            if (isset($_GET['mes']) && isset($_GET['anno'])) {
               $mes = sanitize_text_field($_GET['mes']);
               $anno = sanitize_text_field($_GET['anno']);
               $f_inicio = date('Y-m-d H:i:s', strtotime('first day of ' . $mes . ' ' . $anno));
               $f_final = date('Y-m-d H:i:s', strtotime('last day of ' . $mes . ' ' . $anno));
               $f_final = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($f_final)) . ' 23:59:59'));
            } else {
               $f_inicio = date('Y-m-d H:i:s', strtotime('first day of ' . date('F') . ' ' . date('Y')));
               $f_final = date('Y-m-d H:i:s', strtotime('last day of ' . date('F') . ' ' . date('Y')));
               $f_final = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($f_final)) . ' 23:59:59'));
            }
            if (isset($_GET['fpe'])) {
               $fecha =  sanitize_text_field(($_GET['fpe']));
               $f_inicio = date('Y-m-d H:i:s', strtotime($fecha));
               $f_final = date('Y-m-d 24:00:00', strtotime($fecha));
            }
            $meta_query =
               [
                  [
                     'key' => '_f_proxevento',
                     'value' => [$f_inicio, $f_final],
                     'compare' => 'BETWEEN'
                  ],
                  [
                     'key' => '_periodicidadevento',
                     'value' => $recurrencia,
                     'compare' => $comparar
                  ]
               ];

            $query->set('post_status', ['publish', 'private']);
            $query->set('meta_query', $meta_query);
            $query->set('posts_per_page', 9);
            $query->set('meta_key', '_f_proxevento');
            $query->set('orderby', 'meta_value');
            $query->set('order', 'ASC');
         }
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
   public function set_fpe()
   {
      if (isset($_GET['fpe'])) {
         $fpe_param = sanitize_text_field($_GET['fpe']);
         $mesEvento = date('F', strtotime($fpe_param));
         $annoEvento = date('Y', strtotime($fpe_param));
      } else {
         $fpe_param = 0;
         $mesEvento = isset($_GET['mes']) ? sanitize_text_field($_GET['mes']) : date('F');
         $annoEvento = isset($_GET['anno']) ? sanitize_text_field($_GET['anno']) : date('Y');
      }

      $eventos = get_posts([
         'post_type' => 'evento',
         'post_status' => ['publish', 'private'],
         'posts_per_page' => -1,
      ]);
      foreach ($eventos as $evento) {
         if (get_post_meta($evento->ID, '_diasemanaevento', true) == null) {
            $diasemanaevento = [];
         } else {
            $diasemanaevento = get_post_meta($evento->ID, '_diasemanaevento', true);
         }
         $fechasevento = $this->sae_fechasevento(
            $evento->ID,
            $fpe_param,
            date('Y-m-d H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true))),
            get_post_meta($evento->ID, '_f_final', true),
            get_post_meta($evento->ID, '_h_final', true),
            get_post_meta($evento->ID, '_periodicidadevento', true),
            get_post_meta($evento->ID, '_npereventos', true),
            get_post_meta($evento->ID, '_opcionesquema', true),
            get_post_meta($evento->ID, '_numerodiaordinalevento', true),
            $diasemanaevento,
            get_post_meta($evento->ID, '_mesevento', true),
            $mesEvento,
            $annoEvento
         );
         if (count($fechasevento)) {
            /**
             * 
             * Extraer aquí las fechas excluidas con la función array_diff().
             * 
             * Y modificar los horarios para las fechas registradas con cambio de horario
             * mediante un foreach
             * 
             */

            if ($fpe_param != 0) {
               $fpe_param = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($fpe_param)) . ' ' . date('H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true)))));
               if (in_array($fpe_param, $fechasevento)) {
                  $fpe = $fpe_param;
               } else {
                  $fpe = date('Y-m-d H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true)));
               }
            } else {
               $fpe_actual = [];
               foreach ($fechasevento as $fecha) {
                  if (date('F', strtotime($fecha)) == date('F') && date('Y', strtotime($fecha)) == date('Y')) {
                     if (date('d', strtotime($fecha)) >= date('d')) {
                        $fpe_actual[] = $fecha;
                        if ($evento->ID == 1890) {
                           wp_die(print_r($fecha));
                        }
                     }
                  } else {
                     if (date('F', strtotime($fecha)) == $mesEvento && date('Y', strtotime($fecha)) == $annoEvento) {
                        $fpe_actual[] = $fecha;
                     }
                  }
               }
               if (count($fpe_actual)) {
                  $fpe = min($fpe_actual);
               } else {
                  $fpe = date('Y-m-d H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true)));
               }
            }
         } else {
            $fpe = date('Y-m-d H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true)));
         }
         $h_nuevo = get_post_meta($evento->ID, '_horario_diferenciado', true);
         if ($h_nuevo != null) {
            foreach ($h_nuevo as $fecha) {
               $horarios = json_decode($fecha, true);
               foreach ($horarios as $fecha => $horas) {
                  if (date('Y-m-d', strtotime($fpe)) == $fecha) {
                     $fpe = date('Y-m-d H:i', strtotime($fecha . ' ' . $horas['h_inicial']));
                  }
               }
            }
         }
         update_post_meta($evento->ID, '_f_proxevento', $fpe);
      }
   }
   public function sae_fechasevento($evento_ID, $fpe_param, $finicio = '', $ffinal = '', $h_final = '', $tipoevento = '', $npereventos = '', $opcionesquema = '', $diaordinalevento = '', $diasemanaevento = [], $mesevento = '', $mesConsulta = '', $anno = '')
   {
      $fechasevento = [];
      $f_inicio_mes = date('Y-m-d H:i:s', strtotime('first day of ' . $mesConsulta . ' ' . $anno));
      $f_final_mes = date('Y-m-d H:i:s', strtotime('last day of ' . $mesConsulta . ' ' . $anno));

      /********************************************************
       * 
       * Obtiene todas las fechas de un mes para todos los
       * evntos: Recurrentes y eventos diarios, semanales, 
       * mensuales y anuales. 
       * 
       ********************************************************/

      if (($finicio <= $f_final_mes && $ffinal >= $f_inicio_mes) || ($finicio <= $f_final_mes && $ffinal == '')) {


         if ($ffinal == '' || $ffinal > $f_final_mes) {
            $ffinal = $f_final_mes;
         }

         $f_inicio = new \DateTime($finicio);
         $f_final = new \DateTime($ffinal);
         $diferencia = $f_inicio->diff($f_final);
         $dias = $diferencia->days;
         $semanas = round($dias / 7);
         $meses = $diferencia->y * 12 + $diferencia->m + 1;
         $anios = $diferencia->y;
         $fechaCal = $finicio;

         switch ($tipoevento) {
            case '1': //Evento Único
               $fechasevento[] = $finicio;
               break;

            case '2': //Evento Diario
               for ($i = 1; $i <= $dias + 1; $i++) {
                  if (date('Ym', strtotime($fechaCal)) == date('Ym', strtotime($f_final_mes))) {
                     $fechasevento[] = $fechaCal;
                  }
                  $fechaCal = date('Y-m-d H:i:s', strtotime('+ ' . $i * $npereventos . ' days', strtotime($finicio)));
               }
               break;

            case '3':  //Evento Semanal por día de la semana.
               for ($i = 1; $i <= round($semanas / $npereventos) + 1; $i++) {
                  for ($j = 1; $j <= 7; ++$j) {
                     if (in_array(date('N', strtotime($fechaCal)), $diasemanaevento)) {
                        if (date('Ym', strtotime($fechaCal)) == date('Ym', strtotime($f_final_mes))) {
                           $fechasevento[] = $fechaCal;
                        }
                     }
                     $fechaCal = date('Y-m-d H:i:s', strtotime($fechaCal . ' +1 days'));
                  }
                  $fechaCal = date('Y-m-d H:i:s', strtotime($finicio . ' +' . $i * $npereventos . ' weeks'));
               }
               break;

            case '4':  //Evento Mensual día de mes o día ordinal y día semana.
               if ($opcionesquema == 'off') {
                  for ($i = 1; $i < round($meses / $npereventos) + 1; $i++) {
                     if (date('j', strtotime($finicio)) > date('j', strtotime('last day of ' . $f_final_mes))) {
                        $fechasevento[] = $f_final_mes;
                        break;
                     } else {
                        if (date('Ym', strtotime($fechaCal)) == date('Ym', strtotime($f_final_mes))) {
                           $fechasevento[] = $fechaCal;
                        }
                     }
                     $fechaCal = date('Y-m-d H:i:s', strtotime($finicio . ' +' . $i * $npereventos . ' months'));
                  }
               } else {
                  for ($i = 1; $i < round($meses / $npereventos) + 1; $i++) {
                     foreach ($diasemanaevento as $dia) {
                        $fechaCal = date('Y-m-d H:i:s', strtotime($this->get_atributo('diaordinal')[$diaordinalevento] . ' ' . date('l', strtotime("Sunday +{$dia} days")) . ' of '  . date('Y-m-d', strtotime($fechaCal)) . ' ' . date('H:i:s', strtotime($finicio))));
                        if (date('Ym', strtotime($fechaCal)) == date('Ym', strtotime($f_final_mes))) {
                           $fechasevento[] = $fechaCal;
                        }
                     }
                     $fechaCal = date('Y-m-d H:i:s', strtotime($finicio . ' +' . $i * $npereventos . ' months'));
                  }
               }
               break;

            case '5': //Evento Anual con día de mes y mes o día ordinal, día semana y mes del año
               if ($opcionesquema == 'off') {
                  for ($i = 1; $i <= round($anios / $npereventos) + 1; $i++) {
                     if (date('Ym', strtotime($fechaCal)) == date('Ym', strtotime($f_final_mes))) {
                        $fechasevento[] = $fechaCal;
                     }
                     $fechaCal = date('Y-m-d H:i:s', strtotime($finicio . ' +' . $i * $npereventos . ' years'));
                  }
               } else {
                  for ($i = 1; $i <= round($anios / $npereventos) + 1; $i++) {
                     foreach ($diasemanaevento as $dia) {
                        $fechaCal = date('Y-m-d H:i:s', strtotime($this->get_atributo('diaordinal')[$diaordinalevento] . ' ' . $this->get_atributo('diasemana')[$dia] . ' of '  . date('Y-m-d', strtotime($fechaCal)) . ' ' . date('H:i:s', strtotime($finicio))));

                        if (date('Ym', strtotime($fechaCal)) == date('Ym', strtotime($f_final_mes))) {
                           $fechasevento[] = $fechaCal;
                        }
                     }
                     $fechaCal = date('Y-m-d H:i:s', strtotime($finicio . ' +' . $i * $npereventos . ' years'));
                  }
               }
               break;

            default:
               $fechasevento[] = $finicio;
               break;
         }
      }
      // wp_die(print_r($fechasevento));
      return $fechasevento;
   }
   public function crear_roles()
   {
      /**
       * Editor: alguien que puede publicar y administrar publicaciones, incluidas las publicaciones de otros usuarios.
       * Autor: alguien que puede publicar y administrar sus propias publicaciones.
       * Colaborador: alguien que puede escribir y administrar sus propias publicaciones, pero no puede publicarlas (draft).
       */

      // update_option('evento_roles', false);
      if (!get_option('evento_roles')) {
         add_role('eventoeditor', 'Editor de Eventos', get_role('subscriber')->capabilities);
         add_role('eventoautor', 'Autor de Eventos', get_role('subscriber')->capabilities);
         add_role('eventocolaborador', 'Colaborador Eventos', get_role('subscriber')->capabilities);
         update_option('evento_roles', true);
      }
   }
   private function get_categorias()
   {
      $datos = [];
      $categorias = wp_get_post_terms(get_the_ID(), 'evento_cat', ['exclude' => 1]);
      foreach ($categorias as $categoria) {
         $datos[] = ['enlace' => get_term_link($categoria->term_id), 'nombre' => $categoria->name];
      }
      return $datos;
   }
   private function get_etiquetas()
   {
      $datos = [];
      $categorias = wp_get_post_terms(get_the_ID(), 'evento_tag');
      foreach ($categorias as $categoria) {
         $datos[] = ['enlace' => get_term_link($categoria->term_id), 'nombre' => $categoria->name];
      }
      return $datos;
   }
   private function get_calendario()
   {
      $datos['espacios'] = 0;
      $datos['restante'] = 0;
      if (isset($_GET['fpe'])) {
         $datos['mesConsultaLink'] = 'fpe=' . sanitize_text_field($_GET['fpe']);
         $datos['mesConsulta'] = date('F', strtotime(sanitize_text_field($_GET['fpe'])));
         $datos['mes'] = date('F', strtotime(sanitize_text_field($_GET['fpe'])));
         $datos['anno'] = date('Y', strtotime(sanitize_text_field($_GET['fpe'])));
         $datos['espacios'] = date('N', strtotime('first day of ' . $datos['mes'] . ' ' . $datos['anno'])) - 1;
         $datos['restante'] = 8 - $datos['espacios'];
      } else {
         if (isset($_GET['mes']) && isset($_GET['anno'])) {
            $datos['mes'] = sanitize_text_field($_GET['mes']);
            $datos['anno'] = sanitize_text_field($_GET['anno']);
            $datos['mesConsultaLink'] = 'mes=' . $datos['mes'];
            $datos['mesConsulta'] = $datos['mes'];
            $datos['espacios'] = date('N', strtotime('first day of ' . $datos['mes'] . ' ' . $datos['anno'])) - 1;
            $datos['restante'] = 8 - $datos['espacios'];
         } else {
            $datos['mes'] = date('F');
            $datos['anno'] = date('Y');
            $datos['mesConsultaLink'] = 'mes=' . $datos['mes'];
            $datos['mesConsulta'] = $datos['mes'];
            $datos['espacios'] = date('N', strtotime('first day of ' . $datos['mes'])) - 1;
            $datos['restante'] = 8 - $datos['espacios'];
         }
      }
      return $datos;
   }
   public function get_calendario_fecha($fpe, $mes, $anno)
   {
      $datos['espacios'] = 0;
      $datos['restante'] = 0;
      if ($fpe != 0) {
         $datos['mesConsultaLink'] = 'fpe=' . $fpe;
         $datos['mesConsulta'] = date('F', strtotime($fpe));
         $datos['mes'] = date('F', strtotime($fpe));
         $datos['anno'] = date('Y', strtotime($fpe));
         $datos['espacios'] = date('N', strtotime('first day of ' . $datos['mes'] . ' ' . $datos['anno'])) - 1;
         $datos['restante'] = 8 - $datos['espacios'];
      } else {
         if ($mes != 0 && $anno != 0) {
            $datos['mes'] = $mes;
            $datos['anno'] = $anno;
            $datos['mesConsultaLink'] = 'mes=' . $datos['mes'];
            $datos['mesConsulta'] = $datos['mes'];
            $datos['espacios'] = date('N', strtotime('first day of ' . $datos['mes'] . ' ' . $datos['anno'])) - 1;
            $datos['restante'] = 8 - $datos['espacios'];
         } else {
            $datos['mes'] = date('F');
            $datos['anno'] = date('Y');
            $datos['mesConsultaLink'] = 'mes=' . $datos['mes'];
            $datos['mesConsulta'] = $datos['mes'];
            $datos['espacios'] = date('N', strtotime('first day of ' . $datos['mes'])) - 1;
            $datos['restante'] = 8 - $datos['espacios'];
         }
      }
      return $datos;
   }
   private function t_tipEvento($postType)
   {
      $datos = [];
      if (is_single()) {
         $datos['evento_diario'] = "modules/sae/$postType/view/$postType-diario-edit";
         $datos['evento_semanal'] = "modules/sae/$postType/view/$postType-semanal-edit";
         $datos['evento_mensual'] = "modules/sae/$postType/view/$postType-mensual-edit";
         $datos['evento_anual'] = "modules/sae/$postType/view/$postType-anual-edit";
      } else {
         $datos['evento_diario'] = "modules/sae/$postType/view/$postType-diario";
         $datos['evento_semanal'] = "modules/sae/$postType/view/$postType-semanal";
         $datos['evento_mensual'] = "modules/sae/$postType/view/$postType-mensual";
         $datos['evento_anual'] = "modules/sae/$postType/view/$postType-anual";
      }
      return $datos;
   }
   private function get_f_cancelada($post_id)
   {
      if (isset($_GET['fpe'])) {
         if (get_post_meta($post_id, '_f_excluidas', true) != null) {
            if (in_array(date('Y-m-d', strtotime($_GET['fpe'])), get_post_meta($post_id, '_f_excluidas', true))) {
               return '(Fecha Cancelada)';
            }
         }
      }
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
   public function registrar_evento()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'evento')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {
         $post_name = 'eve_' . bin2hex(random_bytes(5));
         $title = sanitize_text_field($_POST['title']);
         $content = sanitize_textarea_field($_POST['content']);
         $periodicidadevento = sanitize_text_field($_POST['periodicidadevento']);
         if (isset($_POST['inscripcion'])) {
            $inscripcion = sanitize_text_field($_POST['inscripcion']);
         } else {
            $inscripcion = 'off';
         }
         if (isset($_POST['donativo'])) {
            $donativo = sanitize_text_field($_POST['donativo']);
         } else {
            $donativo = 'off';
         }
         if (isset($_POST['montodonativo'])) {
            $montodonativo = sanitize_text_field($_POST['montodonativo']);
         } else {
            $montodonativo = 0;
         }
         if (isset($_POST['aforo'])) {
            $aforo = sanitize_text_field($_POST['aforo']);
         } else {
            $aforo = 'off';
         }
         if (isset($_POST['q_aforo'])) {
            $q_aforo = sanitize_text_field($_POST['q_aforo']);
         } else {
            $q_aforo = 0;
         }
         if (isset($_POST['dia_completo'])) {
            $dia_completo = sanitize_text_field($_POST['dia_completo']);
         } else {
            $dia_completo = 'off';
         }
         if (isset($_POST['evento_virtual'])) {
            $evento_virtual = sanitize_text_field($_POST['evento_virtual']);
         } else {
            $evento_virtual = 'off';
         }
         $enlace_virtual = sanitize_text_field($_POST['enlace_virtual']);
         $d_name = sanitize_text_field($_POST['d_name']);
         $address = sanitize_text_field($_POST['address']);
         $latitud = sanitize_text_field($_POST['latitud']);
         $longitud = sanitize_text_field($_POST['longitud']);
         $f_inicio = sanitize_text_field($_POST['f_inicio']);
         $h_inicio = sanitize_text_field($_POST['h_inicio']);
         $f_inicio = date('Y-m-d H:i:s', strtotime($f_inicio . ' ' . $h_inicio));
         $f_final = sanitize_text_field($_POST['f_final']);
         $h_final = sanitize_text_field($_POST['h_final']);
         if ($f_final != '') {
            $f_final = date('Y-m-d H:i:s', strtotime($f_final . ' ' . $h_final));
         }
         $post_status = sanitize_text_field($_POST['post_status']);
         $post_author = sanitize_text_field($_POST['post_author']);
         $wp_data = array(
            'post_type' => 'evento',
            'post_title' => $title,
            'post_content' => $content,
            'post_name' => $post_name,
            'post_status' => $post_status,
            'post_author' => $post_author,
         );
         $meta_input = array(
            '_f_inicio' => $f_inicio,
            '_h_final' => $h_final,
            '_f_final' => $f_final,
            '_dia_completo' => $dia_completo,
            '_periodicidadevento' => $periodicidadevento,
            '_inscripcion' => $inscripcion,
            '_donativo' => $donativo,
            '_montodonativo' => $montodonativo,
            '_aforo' => $aforo,
            '_q_aforo' => $q_aforo,
            '_f_proxevento' => $f_inicio
         );
         if ($periodicidadevento == 2) {
            $npereventos = sanitize_text_field($_POST['npereventosdiario']);
            $meta_input['_npereventos'] = $npereventos;
         } elseif ($periodicidadevento == 3) {
            $npereventos = sanitize_text_field($_POST['npereventossemana']);
            $meta_input['_npereventos'] = $npereventos;
            $diasemanaevento = array_map('sanitize_text_field', $_POST['diasemana']);
            $meta_input['_diasemanaevento'] = $diasemanaevento;
         } elseif ($periodicidadevento == 4) {
            if (isset($_POST['opcion_mensual'])) {
               $opcionesquema = sanitize_text_field($_POST['opcion_mensual']);
               $meta_input['_opcionesquema'] = $opcionesquema;
               $npereventos = sanitize_text_field($_POST['npereventosmes2']);
               $meta_input['_npereventos'] = $npereventos;
               $numerodiaordinalevento = sanitize_text_field($_POST['numerodiaordinalevento']);
               $meta_input['_numerodiaordinalevento'] = $numerodiaordinalevento;
               $diasemanaevento = array_map('sanitize_text_field', $_POST['diasemanames']);
               $meta_input['_diasemanaevento'] = $diasemanaevento;
            } else {
               $opcionesquema = 'off';
               $meta_input['_opcionesquema'] = $opcionesquema;
               $npereventos = sanitize_text_field($_POST['npereventosmes1']);
               $meta_input['_npereventos'] = $npereventos;
               $numerodiaevento = sanitize_text_field($_POST['numerodiaevento']);
               $meta_input['_numerodiaevento'] = $numerodiaevento;
            }
         } elseif ($periodicidadevento == 5) {
            if (isset($_POST['opcion_anual'])) {
               $opcionesquema = sanitize_text_field($_POST['opcion_anual']);
               $meta_input['_opcionesquema'] = $opcionesquema;
               $npereventos = sanitize_text_field($_POST['npereventosanno2']);
               $meta_input['_npereventos'] = $npereventos;
               $numerodiaordinalevento = sanitize_text_field($_POST['numerodiaordinaleventoanno']);
               $meta_input['_numerodiaordinalevento'] = $numerodiaordinalevento;
               $diasemanaevento = array_map('sanitize_text_field', $_POST['diasemanaanno']);
               $meta_input['_diasemanaevento'] = $diasemanaevento;
               $mesevento = sanitize_text_field($_POST['mesop2']);
               $meta_input['_mesevento'] = $mesevento;
            } else {
               $opcionesquema = 'off';
               $meta_input['_opcionesquema'] = $opcionesquema;
               $npereventos = sanitize_text_field($_POST['npereventosanno1']);
               $meta_input['_npereventos'] = $npereventos;
               $numerodiaevento = sanitize_textarea_field($_POST['numerodiaeventoanno']);
               $meta_input['_numerodiaevento'] = $numerodiaevento;
               $mesevento = sanitize_text_field($_POST['mesop1']);
               $meta_input['_mesevento'] = $mesevento;
            }
         }
         $meta_input['_f_proxevento_excluida'] = 'off';
         if (isset($_POST['cambio_horario']) && $_POST['cambio_horario'] == 'on') {
            $meta_input['_cambio_horario'] = sanitize_text_field($_POST['cambio_horario']);
            if (isset($_POST['f_excluidas'])) {
               $meta_input['_f_excluidas'] = array_map('sanitize_text_field', $_POST['f_excluidas']);
            }
            if (isset($_POST['h_nuevo'])) {
               $meta_input['_horario_diferenciado'] = array_map('sanitize_text_field', $_POST['h_nuevo']);
            }
         } else {
            $meta_input['_cambio_horario'] = 'off';
         }
         if (isset($_POST['event_virtual']) && $_POST['event_virtual'] == 'on') {
            $meta_input['_evento_virtual'] = $evento_virtual;
            $meta_input['_enlace_virtual'] = $enlace_virtual;
         } else {
            $meta_input['_evento_virtual'] = 'off';
            $meta_input['_d_name'] = $d_name;
            $meta_input['_address'] = $address;
            $meta_input['_latitud'] = $latitud;
            $meta_input['_longitud'] = $longitud;
         }

         $post_data = $wp_data + ['meta_input' => $meta_input];
         $post_id = wp_insert_post($post_data);

         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');
         $attach_id = media_handle_upload('evento_imagen', $post_id);
         if (is_wp_error($attach_id)) {
            $attach_id = '';
         } else {
            update_post_meta($post_id, '_thumbnail_id', $attach_id);
         }

         if (isset($_POST['evento_cat_tag']) && $_POST['evento_cat_tag'] == 'on') {
            $evento_cat_dato = json_decode(stripslashes(sanitize_text_field($_POST['evento_cat_dato'])), true);
            $evento_tag_dato = json_decode(stripslashes(sanitize_text_field($_POST['evento_tag_dato'])), true);
            wp_set_object_terms($post_id, $evento_cat_dato, 'evento_cat');
            wp_set_object_terms($post_id, $evento_tag_dato, 'evento_tag');
         }

         $this->send_email(get_permalink($post_id), $title, $post_author);

         wp_send_json_success([$_POST['evento_cat_tag'], 'titulo' => 'Evento Registrado', 'msg' => 'El Evento se registró exitosamente.']);
      }
   }
   private function send_email($enlace, $titulo, $enviar_a_ID)
   {

      $users_email = get_users(['role__in' => 'eventoeditor']);
      if (count($users_email) > 0) {
         foreach ($users_email as $dato) {
            $admin_email = $dato->user_email;
         }
      } else {
         $users_email = get_users(['role__in' => 'useradmingeneral']);
         if (count($users_email) > 0) {
            foreach ($users_email as $dato) {
               $admin_email = $dato->user_email;
            }
         } else {
            $users_email = get_users(['role__in' => 'administrator']);
            if (count($users_email) > 0) {
               foreach ($users_email as $dato) {
                  $admin_email = $dato->user_email;
               }
            }
         }
      }
      $enviar_a = get_user_by('ID', $enviar_a_ID)->user_email;
      $enviar_a_nombre = get_user_by('ID', $enviar_a_ID)->display_name;
      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      $headers[] = 'From: Administración de Eventos<' . $admin_email . '>';
      $headers[] = 'Replay-to: ' . $admin_email;
      // $headers[] = 'CC: ' . $con_copia_nombre . '<' . $con_copia . '>';
      $send_to = $enviar_a;
      $subject = $titulo;

      $mensaje = '';
      $mensaje .= 'Bendiciones, ' . $enviar_a_nombre . ':<br><br>';
      $mensaje .= "El siguiente evento fue creado y asignado a su nombre.<br><br>";
      $mensaje .= '<strong>Nombre del evento:</strong> <a href="' . $enlace . '" >' . $titulo . '</a><br><br>';
      $mensaje .= 'Quedamos a su disposición para cualquier aclaración adicional al respecto.<br><br>';
      $mensaje .= 'Saludos cordiales.';

      try {
         if (wp_mail($send_to, $subject, $mensaje, $headers)) {
            return true;
         } else {
            $mensaje = 'El aviso de acuerdo vencido no pudo ser enviado  al correo ' . $send_to;
            wp_send_json_error(['titulo' => 'e-mail Error', 'msg' => $mensaje]);
         }
      } catch (\Exception $e) {
         wp_send_json_error($e->getMessage());
      }
   }
   public function editar_evento()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'editarevento')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         $evento =
            [
               'titulo' => get_post($post_id)->post_title,
               'contenido' => get_post($post_id)->post_content,
               'imagen' => (get_post_meta($post_id, '_thumbnail_id', true)) ? wp_get_attachment_url(get_post_meta($post_id, '_thumbnail_id', true)) : get_template_directory_uri() . '/assets/img/eventos.jpeg',
               'tipevento' => get_post_meta($post_id, '_periodicidadevento', true),
               'inscripcion' => (get_post_meta($post_id, '_inscripcion', true)) ? get_post_meta($post_id, '_inscripcion', true) : 'off',
               'donativo' => (get_post_meta($post_id, '_donativo', true)) ? get_post_meta($post_id, '_donativo', true) : 'off',
               'montodonativo' => get_post_meta($post_id, '_montodonativo', true),
               'aforo' => (get_post_meta($post_id, '_aforo', true)) ? get_post_meta($post_id, '_aforo', true) : 'off',
               'q_aforo' => get_post_meta($post_id, 'q_aforo', true),
               'f_inicio' => date('Y-m-d', strtotime(get_post_meta($post_id, '_f_inicio', true))),
               'h_inicio' => date('H:i:s', strtotime(get_post_meta($post_id, '_f_inicio', true))),
               'f_final' => (get_post_meta($post_id, '_f_final', true) == '') ? '' : date('Y-m-d', strtotime(get_post_meta($post_id, '_f_final', true))),
               'h_final' => (get_post_meta($post_id, '_f_final', true) == '') ? '' : date('H:i:s', strtotime(get_post_meta($post_id, '_f_final', true))),
               'dia_completo' => get_post_meta($post_id, '_dia_completo', true),
               'opciones_esquema' => get_post_meta($post_id, '_opcionesquema', true),
               'npereventos' => get_post_meta($post_id, '_npereventos', true),
               'diasemanaevento' => explode(',', get_post_meta($post_id, '_diasemanaevento', true)),
               'numerodiaevento' => get_post_meta($post_id, '_numerodiaevento', true),
               'numerodiaordinalevento' => get_post_meta($post_id, '_numerodiaordinalevento', true),
               'mesevento' => get_post_meta($post_id, '_mesevento', true)
            ];

         wp_send_json_success($evento);
      }
   }
   public function modificar_evento()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'modificarevento')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {

         //Registro del post en la base de datos.
         $post_id = sanitize_text_field($_POST['post_id']);
         $title = sanitize_text_field($_POST['title']);
         $content = sanitize_textarea_field($_POST['content']);
         $f_inicio = sanitize_text_field($_POST['f_inicio']);
         $h_inicio = sanitize_text_field($_POST['h_inicio']);
         $f_inicio = date('Y-m-d H:i:s', strtotime($f_inicio . ' ' . $h_inicio));
         $f_final = sanitize_text_field($_POST['f_final']);
         $h_final = sanitize_text_field($_POST['h_final']);
         if ($f_final != '') {
            $f_final = date('Y-m-d H:i:s', strtotime($f_final . ' ' . $h_final));
         }
         if (isset($_POST['dia_completo'])) {
            $dia_completo = sanitize_text_field($_POST['dia_completo']);
         } else {
            $dia_completo = 'off';
         }
         $periodicidadevento = sanitize_text_field($_POST['periodicidadevento']);
         if (isset($_POST['inscripcion'])) {
            $inscripcion = sanitize_text_field($_POST['inscripcion']);
         } else {
            $inscripcion = 'off';
         }
         if (isset($_POST['donativo'])) {
            $donativo = sanitize_text_field($_POST['donativo']);
         } else {
            $donativo = 'off';
         }
         $montodonativo = sanitize_text_field($_POST['montodonativo']);
         if (isset($_POST['aforo'])) {
            $aforo = sanitize_text_field($_POST['aforo']);
         } else {
            $aforo = 'off';
         }
         $q_aforo = sanitize_text_field($_POST['q_aforo']);

         if (isset($_POST['npereventosdiario'])) {
            $npereventos = sanitize_text_field($_POST['npereventosdiario']);
         }
         if (isset($_POST['npereventossemana'])) {
            $npereventos = sanitize_text_field($_POST['npereventossemana']);
         }
         if (isset($_POST['opcion_mensual'])) {
            $opcionesquema = sanitize_text_field($_POST['opcion_mensual']);
         }
         if (isset($_POST['npereventosmes1'])) {
            $npereventos = sanitize_text_field($_POST['npereventosmes1']);
         }
         if (isset($_POST['npereventosmes2'])) {
            $npereventos = sanitize_text_field($_POST['npereventosmes2']);
         }
         if (isset($_POST['opcion_anual'])) {
            $opcionesquema = sanitize_text_field($_POST['opcion_anual']);
         }
         if (isset($_POST['npereventosanno1'])) {
            $npereventos = sanitize_text_field($_POST['npereventosanno1']);
         }
         if (isset($_POST['npereventosanno2'])) {
            $npereventos = sanitize_text_field($_POST['npereventosanno2']);
         }
         if ($npereventos == '') {
            $npereventos = 1;
         }
         if (!isset($opcionesquema)) {
            $opcionesquema = 'off';
         }
         if (isset($_POST['mesop1'])) {
            $mesevento = sanitize_text_field($_POST['mesop1']);
         }
         if (isset($_POST['mesop2'])) {
            $mesevento = sanitize_text_field($_POST['mesop2']);
         }
         if (!isset($mesevento)) {
            $mesevento = '';
         }
         if (isset($_POST['numerodiaevento'])) {
            $numerodiaevento = sanitize_text_field($_POST['numerodiaevento']);
         } else {
            $numerodiaevento = '';
         }
         if (isset($_POST['numerodiaordinalevento'])) {
            $diaordinal = sanitize_text_field($_POST['numerodiaordinalevento']);
         }
         if (isset($_POST['numerodiaordinaleventoanno'])) {
            $diaordinal = sanitize_text_field($_POST['numerodiaordinaleventoanno']);
         }
         if (!isset($diaordinal)) {
            $diaordinal = '';
         }
         if (isset($_POST['diasemanaevento'])) {
            $diasemanaevento = sanitize_text_field($_POST['diasemanaevento']);
         } else {
            $diasemanaevento = '';
         }

         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');

         $attach_id = media_handle_upload('evento_imagen', $post_id);
         if (is_wp_error($attach_id)) {
            $attach_id = '';
         }
         if ($attach_id == '' && get_post_meta($post_id, '_thumbnail_id', true)) {
            $attach_id = get_post_meta($post_id, '_thumbnail_id', true);
         }

         /*
         multiple files loader
         if ($_FILES) {
            foreach ($_FILES as $file => $array) {
               if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                  echo "upload error : " . $_FILES[$file]['error'];
               }
               $attach_id = media_handle_upload($file, $_POST['post_id']);
            }
         }
         */

         $post_data = array(
            'ID' => $post_id,
            'post_type' => 'evento',
            'post_title' => $title,
            'post_content' => $content,
            'post_name' => $post_name,
            'post_status' => 'publish',
            'meta_input' => array(
               '_f_inicio' => $f_inicio,
               '_h_final' => $h_final,
               '_f_final' => $f_final,
               '_dia_completo' => $dia_completo,
               '_thumbnail_id' => $attach_id,
               '_periodicidadevento' => $periodicidadevento,
               '_inscripcion' => $inscripcion,
               '_donativo' => $donativo,
               '_montodonativo' => $montodonativo,
               '_aforo' => $aforo,
               '_q_aforo' => $q_aforo,
               '_opcionesquema' => $opcionesquema,
               '_npereventos' => $npereventos,
               '_diasemanaevento' => $diasemanaevento,
               '_numerodiaevento' => $numerodiaevento,
               '_numerodiaordinalevento' => $diaordinal,
               '_mesevento' => $mesevento,
               '_f_proxevento' => $f_inicio
            )
         );

         wp_update_post($post_data);
         wp_send_json_success(['titulo' => 'Evento Modificado', 'msg' => 'El Evento fue modificado exitosamente.']);
      }
   }
   public function eliminar_evento()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'evento_abc')) {
         wp_send_json_error('Error de seguridad', 401);
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         wp_delete_post($post_id, true);
         $inscripciones = get_posts(['post_type' => 'inscripcion', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => $post_id]);
         if ($inscripciones) {
            foreach ($inscripciones as $inscripcion) {
               wp_delete_post($inscripcion->ID, true);
            }
         }
         wp_send_json_success(['titulo' => 'Evento Eliminado', 'msg' => 'Toda la información relacionada con el evento se eliminó correctamente.']);
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
   private function get_f_tra($fecha, $formato)
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
   private function get_roles_eventos()
   {
      $datos = [];
      foreach (get_users() as $user) {
         foreach ($user->roles as $role) {
            if (strpos($role, 'evento') === 0 || $role === 'administrator' || $role === 'useradmingeneral') {
               if ($user->display_name !== 'Usuarios Borrados') {
                  $datos[] = $user;
               }
               break;
            }
         }
      }
      return $datos;
   }
   public function get_descripcion_evento($post_id)
   {
      $priodicidad = ['1' => 'único', '2' => 'diariamente', '3' => 'semanalmente', '4' => 'mensualmente', '5' => 'anualmente'];
      $dias = ['1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado', '7' => 'Domingo'];
      $ordinal = ['1' => 'primer', '2' => 'segundo', '3' => 'tercer', '4' => 'cuarto', '5' => 'último'];
      $meses = ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];

      $f_final = (get_post_meta($post_id, '_f_final', true) == "") ? "Recurrente" : date('Y-m-d', strtotime(get_post_meta($post_id, '_f_final', true)));

      if ($f_final == "Recurrente") {
         $f_inicial = date('Y-m-d', strtotime(get_post_meta($post_id, '_f_proxevento', true)));
         $f_final = "Recurrente";
      } else {
         $f_inicial = date('Y-m-d', strtotime(get_post_meta($post_id, '_f_inicio', true)));
         $f_final = date('Y-m-d', strtotime(get_post_meta($post_id, '_f_final', true)));
      }
      $inscripcion = get_post_meta($post_id, '_inscripcion', true);
      $donativo = get_post_meta($post_id, '_donativo', true);
      $monto = get_post_meta($post_id, '_montodonativo', true);
      $aforo = get_post_meta($post_id, '_aforo', true);

      //Diario, semana, mes, año
      $cada = get_post_meta($post_id, '_npereventos', true);
      //Semana, mes, año
      $diaSemana = get_post_meta($post_id, '_diasemanaevento', true);
      $esquema = get_post_meta($post_id, '_opcionesquema', true);
      $diaOrdinal = get_post_meta($post_id, '_numerodiaordinalevento', true);
      //Mes y año
      $diaMes = get_post_meta($post_id, '_numerodiaevento', true);
      //Año
      $mes = get_post_meta($post_id, '_mesevento', true);

      $tipoEvento = get_post_meta($post_id, '_periodicidadevento', true);
      $descripcion = '';
      switch ($tipoEvento) {
         case '1':
            $descripcion = "Este es un evento ";
            $descripcion .= $priodicidad[$tipoEvento];
            $descripcion .= (date('Y-m-d') < $f_inicial) ? " y se llevará a cabo el " . $this->get_f_tra($f_inicial, 'EEEE d MMM') : " y se llevó a cabo el " . $this->get_f_tra($f_inicial, 'EEEE d MMM');
            $descripcion .= ($inscripcion == 'on') ? ". Para participar requiere inscribirse " : "";
            $descripcion .= ($donativo == 'on') ? " y el monto de la inscripción por persona es de  " . number_format($monto, 2, ',', '.') : "";
            $descripcion .= ($aforo == 'on') ? " y el cupo es limitado. " : "";
            $descripcion .= ".";
            break;
         case '2':
            //Diario
            $descripcion = "Este es un evento que se repite ";
            $descripcion .= $priodicidad[$tipoEvento];
            $descripcion .= ($cada > 1) ? ", cada " . $cada . " días, " : "";
            if (date('Y-m-d') > $f_final) {
               $descripcion .= " y se llevó a cabo del " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' al ' . $this->get_f_tra($f_final, 'EEEE d MMM');
            } elseif (date('Y-m-d') > $f_inicial && date('Y-m-d') <= $f_final) {
               $descripcion .= " que se inició el " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' y terminará el ' . $this->get_f_tra($f_final, 'EEEE d MMM');
            } else {
               $descripcion .= " y se llevará a cabo del " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' al ' . $this->get_f_tra($f_final, 'EEEE d MMM');
            }
            $descripcion .= ($inscripcion == 'on') ? ". Para participar requiere inscribirse " : "";
            $descripcion .= ($donativo == 'on') ? " y el monto de la inscripción por persona es de  ¢" . number_format($monto, 2, ',', '.') : "";
            $descripcion .= ($aforo == 'on') ? ". El cupo es limitado " : "";
            $descripcion .= ".";
            break;
         case '3':
            //Semanal
            $descripcion = "Este es un evento que se repite ";
            $descripcion .= $priodicidad[$tipoEvento];
            $descripcion .= ($cada > 1) ? ", cada " . $cada . " semanas, " : "";
            $descripcion .= " los días " . $this->get_dias_semana($diaSemana, $dias);
            if ($f_final == "Recurrente") {
               $descripcion .= (date('Y-m-d') < $f_inicial) ? " y se llevará a cabo el " . $this->get_f_tra($f_inicial, 'EEEE d MMM') : " y se llevó a cabo el " . $this->get_f_tra($f_inicial, 'EEEE d MMM');
            } else {
               if (date('Y-m-d') > $f_final) {
                  $descripcion .= " y se llevó a cabo del " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' al ' . $this->get_f_tra($f_final, 'EEEE d MMM');
               } elseif (date('Y-m-d') > $f_inicial && date('Y-m-d') <= $f_final) {
                  $descripcion .= " que se inició el " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' y terminará el ' . $this->get_f_tra($f_final, 'EEEE d MMM');
               } else {
                  $descripcion .= " y se llevará a cabo del " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' al ' . $this->get_f_tra($f_final, 'EEEE d MMM');
               }
            }
            $descripcion .= ($inscripcion == 'on') ? ". Para participar requiere inscribirse " : "";
            $descripcion .= ($donativo == 'on') ? " y el monto de la inscripción por persona es de  ¢" . number_format($monto, 2, ',', '.') : "";
            $descripcion .= ($aforo == 'on') ? ". El cupo es limitado " : "";
            $descripcion .= ".";
            break;
         case '4':
            //Mensual
            $descripcion = "Este es un evento que se repite ";
            $descripcion .= $priodicidad[$tipoEvento];
            $descripcion .= ($cada > 1) ? ", cada " . $cada . " meses, " : "";
            $descripcion .= ($esquema == 'off') ? " el día " . $diaMes . " del mes " : " el " . $ordinal[$diaOrdinal] . " " . $this->get_dias_semana($diaSemana, $dias) . " del mes";
            if ($f_final == "Recurrente") {
               $descripcion .= (date('Y-m-d') < $f_inicial) ? " y se llevará a cabo el " . $this->get_f_tra($f_inicial, 'EEEE d MMM') : " y se llevó a cabo el " . $this->get_f_tra($f_inicial, 'EEEE d MMM');
            } else {
               if (date('Y-m-d') > $f_final) {
                  $descripcion .= " y se llevó a cabo del " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' al ' . $this->get_f_tra($f_final, 'EEEE d MMM');
               } elseif (date('Y-m-d') > $f_inicial && date('Y-m-d') <= $f_final) {
                  $descripcion .= " que se inició el " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' y terminará el ' . $this->get_f_tra($f_final, 'EEEE d MMM');
               } else {
                  $descripcion .= " y se llevará a cabo del " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' al ' . $this->get_f_tra($f_final, 'EEEE d MMM');
               }
            }
            $descripcion .= ($inscripcion == 'on') ? ". Para participar requiere inscribirse " : "";
            $descripcion .= ($donativo == 'on') ? " y el monto de la inscripción por persona es de  ¢" . number_format($monto, 2, ',', '.') : "";
            $descripcion .= ($aforo == 'on') ? ". El cupo es limitado " : "";
            $descripcion .= ".";
            break;
         case '5':
            //Anual
            $descripcion = "Este es un evento que se repite ";
            $descripcion .= $priodicidad[$tipoEvento];
            $descripcion .= ($cada > 1) ? ", cada " . $cada . " años, " : "";
            $descripcion .= ($esquema == 'off') ? " el día " . $diaMes . " del mes de " . $meses[$mes] : " el " . $ordinal[$diaOrdinal] . " " . $this->get_dias_semana($diaSemana, $dias) . " del mes de " . $meses[$mes];
            if ($f_final == "Recurrente") {
               $descripcion .= (date('Y-m-d') < $f_inicial) ? " y se llevará a cabo el " . $this->get_f_tra($f_inicial, 'EEEE d MMM') : " y se llevó a cabo el " . $this->get_f_tra($f_inicial, 'EEEE d MMM');
            } else {
               if (date('Y-m-d') > $f_final) {
                  $descripcion .= " que se llevó a cabo del " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' al ' . $this->get_f_tra($f_final, 'EEEE d MMM');
               } elseif (date('Y-m-d') > $f_inicial && date('Y-m-d') <= $f_final) {
                  $descripcion .= " que se inició el " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' y terminará el ' . $this->get_f_tra($f_final, 'EEEE d MMM');
               } else {
                  $descripcion .= " y se llevará a cabo del " . $this->get_f_tra($f_inicial, 'EEEE d MMM') . ' al ' . $this->get_f_tra($f_final, 'EEEE d MMM');
               }
            }
            $descripcion .= ($inscripcion == 'on') ? ". Para participar requiere inscribirse " : "";
            $descripcion .= ($donativo == 'on') ? " y el monto de la inscripción por persona es de  ¢" . number_format($monto, 2, ',', '.') : "";
            $descripcion .= ($aforo == 'on') ? ". El cupo es limitado " : "";
            $descripcion .= ".";
            break;
         default:
            $descripcion = 'No es posible obtener la descripción del evento';
            break;
      }
      return $descripcion;
   }
   private function get_dias_semana($diaSemana, $dias)
   {
      $diasTexto = [];
      foreach ($diaSemana as $dia) {
         $diasTexto[] = $dias[$dia];
      }

      if (count($diasTexto) > 1) {
         $ultimo = array_pop($diasTexto);
         $resultado = implode(', ', $diasTexto) . ' y ' . $ultimo;
      } else {
         $resultado = implode('', $diasTexto);
      }

      return $resultado;
   }
}
