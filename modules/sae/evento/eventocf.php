<?php

namespace WPFRW\Modules\Sae\Evento;

use WPFRW\Modules\Core\Singleton;

class EventoCF
{
   use Singleton;

   public function __construct()
   {
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'sae_guardar_f_inicio']);
      add_action('save_post', [$this, 'sae_guardar_f_final']);
      add_action('save_post', [$this, 'sae_guardar_dia_completo']);
      add_action('save_post', [$this, 'sae_guardar_periodicidadevento']);
      add_action('save_post', [$this, 'sae_guardar_inscripcion']);
      add_action('save_post', [$this, 'sae_guardar_donativo']);
      add_action('save_post', [$this, 'sae_guardar_montodonativo']);
      add_action('save_post', [$this, 'sae_guardar_aforo']);
      add_action('save_post', [$this, 'sae_guardar_q_aforo']);

      add_action('save_post', [$this, 'sae_guardar_evento_virtual']);
      add_action('save_post', [$this, 'sae_guardar_enlace_virtual']);
      add_action('save_post', [$this, 'sae_guardar_d_name']);
      add_action('save_post', [$this, 'sae_guardar_address']);
      add_action('save_post', [$this, 'sae_guardar_latitud']);
      add_action('save_post', [$this, 'sae_guardar_longitud']);

      add_action('save_post', [$this, 'sae_guardar_opcionesquema']);
      add_action('save_post', [$this, 'sae_guardar_npereventos']);
      add_action('save_post', [$this, 'sae_guardar_diasemanaevento']);
      add_action('save_post', [$this, 'sae_guardar_numerodiaevento']);
      add_action('save_post', [$this, 'sae_guardar_numerodiaordinalevento']);
      add_action('save_post', [$this, 'sae_guardar_mesevento']);
      add_action('save_post', [$this, 'sae_guardar_f_proxevento']);
      add_action('save_post', [$this, 'sae_guardar_q_inscripciones']);
      add_action('save_post', [$this, 'sae_guardar_f_excluidas']);
      add_action('save_post', [$this, 'sae_guardar_horario_diferenciado']);
   }
   public function set_campos()
   {
      add_meta_box(
         'f_inicio',
         'Fecha Inicio',
         [$this, 'sae_crear_f_inicio_cbk'],
         'evento',
         'normal',
         'default',
      );
      add_meta_box(
         'f_final',
         'Fecha Final',
         [$this, 'sae_crear_f_final_cbk'],
         'evento',
         'normal',
         'default',
      );
      add_meta_box(
         'h_final',
         'Hora Final',
         [$this, 'sae_crear_h_final_cbk'],
         'evento',
         'normal',
         'default',
      );
      add_meta_box(
         'dia_completo',
         'Evento Día Completo',
         [$this, 'sae_crear_dia_completo_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'periodicidadevento',
         'Tipo de Evento',
         [$this, 'sae_crear_periodicidadevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'inscripcion',
         'Requiere inscripción',
         [$this, 'sae_crear_inscripcion_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'donativo',
         'Requiere donativo',
         [$this, 'sae_crear_donativo_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'montodonativo',
         'Monto donativo sugerido',
         [$this, 'sae_crear_montodonativo_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'aforo',
         'Requiere Aforo',
         [$this, 'sae_crear_aforo_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'qaforo',
         'Aforo',
         [$this, 'sae_crear_q_aforo_cbk'],
         'evento',
         'normal',
         'default'
      );
      /** */
      add_meta_box(
         'evento_virtual',
         'Evento Virtual',
         [$this, 'sae_crear_evento_virtual_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'enlace_virtual',
         'Enlace Virtual',
         [$this, 'sae_crear_enlace_virtual_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'd_name',
         'Nombre del lugar del evento',
         [$this, 'sae_crear_d_name_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'address',
         'Dirección del evento',
         [$this, 'sae_crear_address_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'latitud',
         'Latitud',
         [$this, 'sae_crear_latitud_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'longitud',
         'Longitud',
         [$this, 'sae_crear_longitud_cbk'],
         'evento',
         'normal',
         'default'
      );
      /** */
      add_meta_box(
         'opcionesquema',
         'Opción Esquema Mensual o Anual',
         [$this, 'sae_crear_opcionesquema_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'npereventos',
         'Número de períodos',
         [$this, 'sae_crear_npereventos_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'diasemanaevento',
         'Día de la Semana',
         [$this, 'sae_crear_diasemanaevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'numerodiaevento',
         'Número del día del mes',
         [$this, 'sae_crear_numerodiaevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'numerodiaordinalevento',
         'Número del día del mes ordinal',
         [$this, 'sae_crear_numerodiaordinalevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'mesevento',
         'Mes del evento',
         [$this, 'sae_crear_mesevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'f_proxevento',
         'Fecha Próximo Evento',
         [$this, 'sae_crear_f_proxevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'q_inscripciones',
         'Cantidad de personas inscritas',
         [$this, 'sae_crear_q_inscripciones_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'cambio_horario',
         'Opción Cambio Horario',
         [$this, 'sae_crear_cambio_horario_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'f_excluidas',
         'Fechas Excluidas',
         [$this, 'sae_crear_f_excluidas_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'horario_diferenciado',
         'Horario Diferenciado',
         [$this, 'sae_crear_horario_diferenciado_cbk'],
         'evento',
         'normal',
         'default'
      );
   }
   public function sae_crear_f_inicio_cbk($post)
   {
      wp_nonce_field('f_inicio_nonce', 'f_inicio_nonce');
      $f_inicio = get_post_meta($post->ID, '_f_inicio', true);
      echo '<input type="datetime-local" style="width:20%" id="f_inicio" name="f_inicio" placeholder="yyyy-mm-dd hh:mm" value="' . esc_attr($f_inicio) . '" ></input>';
   }
   public function sae_guardar_f_inicio($post_id)
   {
      if (!isset($_POST['f_inicio_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_inicio_nonce'], 'f_inicio_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['f_inicio'])) {
         return;
      }
      $f_inicio = sanitize_text_field($_POST['f_inicio']);
      update_post_meta($post_id, '_f_inicio', $f_inicio);
   }
   public function sae_crear_f_final_cbk($post)
   {
      wp_nonce_field('f_final_nonce', 'f_final_nonce');
      $f_final = get_post_meta($post->ID, '_f_final', true);
      echo '<input type="datetime-local" style="width:20%" id="f_final" name="f_final" value="' . esc_attr($f_final) . '" ></input>';
   }
   public function sae_guardar_f_final($post_id)
   {
      if (!isset($_POST['f_final_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_final_nonce'], 'f_final_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['f_final'])) {
         return;
      }
      $f_final = sanitize_text_field($_POST['f_final']);
      if ($f_final != '') {
         $f_final = date('Y-m-d H:i:s', strtotime($f_final));
      }
      update_post_meta($post_id, '_f_final', $f_final);
   }
   public function sae_crear_h_final_cbk($post)
   {
      wp_nonce_field('h_final_nonce', 'h_final_nonce');
      $h_final = get_post_meta($post->ID, '_h_final', true);
      echo '<input type="time" style="width:20%" id="h_final" name="h_final" value="' . esc_attr($h_final) . '" ></input>';
   }
   public function sae_guardar_h_final($post_id)
   {
      if (!isset($_POST['h_final_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['h_final_nonce'], 'h_final_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['h_final'])) {
         return;
      }
      $h_final = sanitize_text_field($_POST['h_final']);
      if ($h_final != '') {
         $h_final = date('H:i', strtotime($h_final));
      }
      update_post_meta($post_id, '_h_final', $h_final);
   }
   public function sae_crear_dia_completo_cbk($post)
   {
      wp_nonce_field('dia_completo_nonce', 'dia_completo_nonce');
      $dia_completo = get_post_meta($post->ID, '_dia_completo', true);
      echo '<input type="text" style="width:10%" id="dia_completo" name="dia_completo" value="' . esc_attr($dia_completo) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_guardar_dia_completo($post_id)
   {
      if (!isset($_POST['dia_completo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['dia_completo_nonce'], 'dia_completo_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['dia_completo'])) {
         return;
      }
      $dia_completo = sanitize_text_field($_POST['dia_completo']);
      update_post_meta($post_id, '_dia_completo', $dia_completo);
   }
   public function sae_crear_periodicidadevento_cbk($post)
   {
      wp_nonce_field('periodicidadevento_nonce', 'periodicidadevento_nonce');
      $periodicidadevento = get_post_meta($post->ID, '_periodicidadevento', true);
      echo '<input id="periodicidadevento" type="numeric" name="periodicidadevento" min="0" max="5" step="1" value="' . esc_attr($periodicidadevento) . '"> (1=Evento Único, 2=Diario, 3=Semanal, 4=Mensual, 5=Anual)';
   }
   public function sae_guardar_periodicidadevento($post_id)
   {
      if (!isset($_POST['periodicidadevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['periodicidadevento_nonce'], 'periodicidadevento_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['periodicidadevento'])) {
         return;
      }
      $periodicidadevento = sanitize_text_field($_POST['periodicidadevento']);
      update_post_meta($post_id, '_periodicidadevento', $periodicidadevento);
   }
   public function sae_crear_inscripcion_cbk($post)
   {
      wp_nonce_field('inscripcion_nonce', 'inscripcion_nonce');
      $inscripcion = get_post_meta($post->ID, '_inscripcion', true);
      echo '<input type="text" style="width:10%" id="inscripcion" name="inscripcion" value="' . esc_attr($inscripcion) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_guardar_inscripcion($post_id)
   {
      if (!isset($_POST['inscripcion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['inscripcion_nonce'], 'inscripcion_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['inscripcion'])) {
         return;
      }
      $inscripcion = sanitize_text_field($_POST['inscripcion']);
      update_post_meta($post_id, '_inscripcion', $inscripcion);
   }
   public function sae_crear_donativo_cbk($post)
   {
      wp_nonce_field('donativo_nonce', 'donativo_nonce');
      $donativo = get_post_meta($post->ID, '_donativo', true);
      echo '<input type="text" style="width:10%" id="donativo" name="donativo" value="' . esc_attr($donativo) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_guardar_donativo($post_id)
   {
      if (!isset($_POST['donativo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['donativo_nonce'], 'donativo_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['donativo'])) {
         return;
      }
      $donativo = sanitize_text_field($_POST['donativo']);
      update_post_meta($post_id, '_donativo', $donativo);
   }
   public function sae_crear_montodonativo_cbk($post)
   {
      wp_nonce_field('montodonativo_nonce', 'montodonativo_nonce');
      $montodonativo = get_post_meta($post->ID, '_montodonativo', true);
      echo '<input type="numeric" style="width:10%" id="montodonativo" name="montodonativo" min="0.00" max="1000000.00" step="1000.00" value="' . esc_attr($montodonativo) . '" ></input>';
   }
   public function sae_guardar_montodonativo($post_id)
   {
      if (!isset($_POST['montodonativo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['montodonativo_nonce'], 'montodonativo_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['montodonativo'])) {
         return;
      }
      $montodonativo = sanitize_text_field($_POST['montodonativo']);
      update_post_meta($post_id, '_montodonativo', $montodonativo);
   }
   public function sae_crear_aforo_cbk($post)
   {
      wp_nonce_field('aforo_nonce', 'aforo_nonce');
      $aforo = get_post_meta($post->ID, '_aforo', true);
      echo '<input type="text" style="width:10%" id="aforo" name="aforo" value="' . esc_attr($aforo) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_guardar_aforo($post_id)
   {
      if (!isset($_POST['aforo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['aforo_nonce'], 'aforo_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['aforo'])) {
         return;
      }
      $aforo = sanitize_text_field($_POST['aforo']);
      update_post_meta($post_id, '_aforo', $aforo);
   }
   public function sae_crear_q_aforo_cbk($post)
   {
      wp_nonce_field('q_aforo_nonce', 'q_aforo_nonce');
      $q_aforo = get_post_meta($post->ID, '_q_aforo', true);
      echo '<input type="numeric" style="width:10%" id="q_aforo" name="q_aforo" min="0" max="1000000" step="1" value="' . esc_attr($q_aforo) . '" ></input>';
   }
   public function sae_guardar_q_aforo($post_id)
   {
      if (!isset($_POST['q_aforo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['q_aforo_nonce'], 'q_aforo_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['q_aforo'])) {
         return;
      }
      $q_aforo = sanitize_text_field($_POST['q_aforo']);
      update_post_meta($post_id, '_q_aforo', $q_aforo);
   }
   public function sae_crear_evento_virtual_cbk($post)
   {
      wp_nonce_field('evento_virtual_nonce', 'evento_virtual_nonce');
      $evento_virtual = get_post_meta($post->ID, '_evento_virtual', true);
      echo '<input type="text" style="width:10%" id="evento_virtual" name="evento_virtual" value="' . esc_attr($evento_virtual) . '" > ("off" = No, "on" = Sí)';
   }
   public function sae_guardar_evento_virtual($post_id)
   {
      if (!isset($_POST['evento_virtual_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['evento_virtual_nonce'], 'evento_virtual_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['evento_virtual'])) {
         return;
      }
      $evento_virtual = sanitize_text_field($_POST['evento_virtual']);
      update_post_meta($post_id, '_evento_virtual', $evento_virtual);
   }
   public function sae_crear_enlace_virtual_cbk($post)
   {
      wp_nonce_field('enlace_virtual_nonce', 'enlace_virtual_nonce');
      $enlace_virtual = get_post_meta($post->ID, '_enlace_virtual', true);
      echo '<input type="text" style="width:50%" id="enlace_virtual" name="enlace_virtual" value="' . esc_attr($enlace_virtual) . '" >';
   }
   public function sae_guardar_enlace_virtual($post_id)
   {
      if (!isset($_POST['enlace_virtual_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['enlace_virtual_nonce'], 'enlace_virtual_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['enlace_virtual'])) {
         return;
      }
      $enlace_virtual = sanitize_text_field($_POST['enlace_virtual']);
      update_post_meta($post_id, '_enlace_virtual', $enlace_virtual);
   }
   public function sae_crear_d_name_cbk($post)
   {
      wp_nonce_field('d_name_nonce', 'd_name_nonce');
      $d_name = get_post_meta($post->ID, '_d_name', true);
      echo '<input type="text" style="width:50%;" id="d_name" name="d_name" value="' . esc_attr($d_name) . '" ></input>';
   }
   public function sae_guardar_d_name($post_id)
   {
      if (!isset($_POST['d_name_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['d_name_nonce'], 'd_name_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['d_name'])) {
         return;
      }
      $d_name = sanitize_text_field($_POST['d_name']);
      update_post_meta($post_id, '_d_name', $d_name);
   }
   public function sae_crear_address_cbk($post)
   {
      wp_nonce_field('address_nonce', 'address_nonce');
      $address = get_post_meta($post->ID, '_address', true);
      echo '<input type="text" style="width:50%;" id="address" name="address" value="' . esc_attr($address) . '" ></input>';
   }
   public function sae_guardar_address($post_id)
   {
      if (!isset($_POST['address_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['address_nonce'], 'address_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['address'])) {
         return;
      }
      $address = sanitize_text_field($_POST['address']);
      update_post_meta($post_id, '_address', $address);
   }
   public function sae_crear_latitud_cbk($post)
   {
      wp_nonce_field('latitud_nonce', 'latitud_nonce');
      $latitud = get_post_meta($post->ID, '_latitud', true);
      echo '<input type="numeric" style="width:30%" id="latitud" name="latitud" min="0" max="1000000" step="1" value="' . esc_attr($latitud) . '" ></input>';
   }
   public function sae_guardar_latitud($post_id)
   {
      if (!isset($_POST['latitud_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['latitud_nonce'], 'latitud_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['latitud'])) {
         return;
      }
      $latitud = sanitize_text_field($_POST['latitud']);
      update_post_meta($post_id, '_latitud', $latitud);
   }
   public function sae_crear_longitud_cbk($post)
   {
      wp_nonce_field('longitud_nonce', 'longitud_nonce');
      $longitud = get_post_meta($post->ID, '_longitud', true);
      echo '<input type="numeric" style="width:30%" id="longitud" name="longitud" min="0" max="1000000" step="1" value="' . esc_attr($longitud) . '" ></input>';
   }
   public function sae_guardar_longitud($post_id)
   {
      if (!isset($_POST['longitud_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['longitud_nonce'], 'longitud_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['longitud'])) {
         return;
      }
      $longitud = sanitize_text_field($_POST['longitud']);
      update_post_meta($post_id, '_longitud', $longitud);
   }
   public function sae_crear_opcionesquema_cbk($post)
   {
      wp_nonce_field('opcionesquema_nonce', 'opcionesquema_nonce');
      $opcionesquema = get_post_meta($post->ID, '_opcionesquema', true);
      echo '<input type="text" style="width:10%" id="opcionesquema" name="opcionesquema" value="' . esc_attr($opcionesquema) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_guardar_opcionesquema($post_id)
   {
      if (!isset($_POST['opcionesquema_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['opcionesquema_nonce'], 'opcionesquema_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['opcionesquema'])) {
         return;
      }
      $opcionesquema = sanitize_text_field($_POST['opcionesquema']);
      update_post_meta($post_id, '_opcionesquema', $opcionesquema);
   }
   public function sae_crear_npereventos_cbk($post)
   {
      wp_nonce_field('npereventos_nonce', 'npereventos_nonce');
      $npereventos = get_post_meta($post->ID, '_npereventos', true);
      echo '<input type="numeric" style="width:10%" id="npereventos" name="npereventos" min="1" max="100" step="1" value="' . esc_attr($npereventos) . '" ></input>';
   }
   public function sae_guardar_npereventos($post_id)
   {
      if (!isset($_POST['npereventos_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['npereventos_nonce'], 'npereventos_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['npereventos'])) {
         return;
      }
      $npereventos = sanitize_text_field($_POST['npereventos']);
      update_post_meta($post_id, '_npereventos', $npereventos);
   }
   public function sae_crear_diasemanaevento_cbk($post)
   {
      wp_nonce_field('diasemanaevento_nonce', 'diasemanaevento_nonce');
      $diasemanaevento = get_post_meta($post->ID, '_diasemanaevento', true);
      if ($diasemanaevento == null) {
         $diasemanaevento = "";
      } else {
         $diasemanaevento = implode(",", $diasemanaevento);
      }
      echo '<input id="diasemanaevento" type="text" name="diasemanaevento" min="1" max="7" step="1" value="' . esc_attr($diasemanaevento) . '"> (1=lunes, 2=martes, 3=miércoles, 4=jueves, 5=viernes, 6=sábado, 7=domingo)';
   }
   public function sae_guardar_diasemanaevento($post_id)
   {
      if (!isset($_POST['diasemanaevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['diasemanaevento_nonce'], 'diasemanaevento_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['diasemanaevento'])) {
         return;
      }
      $diasemanaevento = explode(",", sanitize_text_field($_POST['diasemanaevento']));
      update_post_meta($post_id, '_diasemanaevento', $diasemanaevento);
   }
   public function sae_crear_numerodiaevento_cbk($post)
   {
      wp_nonce_field('numerodiaevento_nonce', 'numerodiaevento_nonce');
      $numerodiaevento = get_post_meta($post->ID, '_numerodiaevento', true);
      echo '<input type="numeric" style="width:10%" id="numerodiaevento" name="numerodiaevento" min="1" max="31" step="1" value="' . esc_attr($numerodiaevento) . '" ></input> (entre 1 y 31)';
   }
   public function sae_guardar_numerodiaevento($post_id)
   {
      if (!isset($_POST['numerodiaevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['numerodiaevento_nonce'], 'numerodiaevento_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['numerodiaevento'])) {
         return;
      }
      $numerodiaevento = sanitize_text_field($_POST['numerodiaevento']);
      update_post_meta($post_id, '_numerodiaevento', $numerodiaevento);
   }
   public function sae_crear_numerodiaordinalevento_cbk($post)
   {
      wp_nonce_field('numerodiaordinalevento_nonce', 'numerodiaordinalevento_nonce');
      $numerodiaordinalevento = get_post_meta($post->ID, '_numerodiaordinalevento', true);
      echo '<input type="numeric" style="width:10%" id="numerodiaordinalevento" name="numerodiaordinalevento" min="0" max="5" step="1" value="' . esc_attr($numerodiaordinalevento) . '" ></input>(""=No aplica, 1=Primer, 2=Segundo, 3=Tercer, 4=Cuarto, 5=Último)';
   }
   public function sae_guardar_numerodiaordinalevento($post_id)
   {
      if (!isset($_POST['numerodiaordinalevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['numerodiaordinalevento_nonce'], 'numerodiaordinalevento_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['numerodiaordinalevento'])) {
         return;
      }
      $numerodiaordinalevento = sanitize_text_field($_POST['numerodiaordinalevento']);
      update_post_meta($post_id, '_numerodiaordinalevento', $numerodiaordinalevento);
   }
   public function sae_crear_mesevento_cbk($post)
   {
      wp_nonce_field('mesevento_nonce', 'mesevento_nonce');
      $mesevento = get_post_meta($post->ID, '_mesevento', true);
      echo '<input type="numeric" style="width:10%" id="mesevento" name="mesevento" min="1" max="12" step="1" value="' . esc_attr($mesevento) . '" ></input>(""=No aplica, 1=Enero,...,12=Diciembre)';
   }
   public function sae_guardar_mesevento($post_id)
   {
      if (!isset($_POST['mesevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['mesevento_nonce'], 'mesevento_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['mesevento'])) {
         return;
      }
      $mesevento = sanitize_text_field($_POST['mesevento']);
      update_post_meta($post_id, '_mesevento', $mesevento);
   }
   public function sae_crear_f_proxevento_cbk($post)
   {
      wp_nonce_field('f_proxevento_nonce', 'f_proxevento_nonce');
      $f_proxevento = get_post_meta($post->ID, '_f_proxevento', true);
      echo '<input type="datetime-local" style="width:20%" id="f_proxevento" name="f_proxevento" value="' . esc_attr($f_proxevento) . '" ></input>';
   }
   public function sae_guardar_f_proxevento($post_id)
   {
      if (!isset($_POST['f_proxevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_proxevento_nonce'], 'f_proxevento_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['f_proxevento'])) {
         return;
      }
      $f_proxevento = sanitize_text_field($_POST['f_proxevento']);
      $f_proxevento = date('Y-m-d H:i:s', strtotime($f_proxevento));
      update_post_meta($post_id, '_f_proxevento', $f_proxevento);
   }
   public function sae_crear_q_inscripciones_cbk($post)
   {
      wp_nonce_field('q_inscripciones_nonce', 'q_inscripciones_nonce');
      $q_inscripciones = get_post_meta($post->ID, '_q_inscripciones', true);
      echo '<input type="numeric" style="width:10%" id="q_inscripciones" name="q_inscripciones" min="1" max="1000" step="1" value="' . esc_attr($q_inscripciones) . '" ></input>';
   }
   public function sae_guardar_q_inscripciones($post_id)
   {
      if (!isset($_POST['q_inscripciones_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['q_inscripciones_nonce'], 'q_inscripciones_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['q_inscripciones'])) {
         return;
      }
      $q_inscripciones = sanitize_text_field($_POST['q_inscripciones']);
      update_post_meta($post_id, '_q_inscripciones', $q_inscripciones);
   }
   public function sae_crear_f_excluidas_cbk($post)
   {
      wp_nonce_field('f_excluidas_nonce', 'f_excluidas_nonce');
      $f_excluidas = get_post_meta($post->ID, '_f_excluidas', true);
      if ($f_excluidas == null) {
         $f_excluidas = "";
      } else {
         $f_excluidas = implode(",", $f_excluidas);
      }
      echo '<input type="text" style="width:75%" id="f_excluidas" name="f_excluidas" value="' . esc_attr($f_excluidas) . '" ></input>';
   }
   public function sae_guardar_f_excluidas($post_id)
   {
      if (!isset($_POST['f_excluidas_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_excluidas_nonce'], 'f_excluidas_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['f_excluidas'])) {
         return;
      }
      $f_excluidas = explode(",", sanitize_text_field($_POST['f_excluidas']));
      update_post_meta($post_id, '_f_excluidas', $f_excluidas);
   }
   public function sae_crear_cambio_horario_cbk($post)
   {
      wp_nonce_field('cambio_horario_nonce', 'cambio_horario_nonce');
      $cambio_horario = get_post_meta($post->ID, '_cambio_horario', true);
      echo '<input type="text" style="width:10%" id="cambio_horario" name="cambio_horario" value="' . esc_attr($cambio_horario) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_guardar_cambio_horario($post_id)
   {
      if (!isset($_POST['cambio_horario_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['cambio_horario_nonce'], 'cambio_horario_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['cambio_horario'])) {
         return;
      }
      $cambio_horario = sanitize_text_field($_POST['cambio_horario']);
      update_post_meta($post_id, '_cambio_horario', $cambio_horario);
   }
   public function sae_crear_horario_diferenciado_cbk($post)
   {
      wp_nonce_field('horario_diferenciado_nonce', 'horario_diferenciado_nonce');
      $horario_diferenciado = get_post_meta($post->ID, '_horario_diferenciado', true);
      if ($horario_diferenciado == null) {
         $horario_diferenciado =  "";
      } else {
         $horario_diferenciado = implode(",", $horario_diferenciado);
      }
      echo '<input type="text" style="width:75%" id="horario_diferenciado" name="horario_diferenciado" value="' . esc_attr($horario_diferenciado) . '" ></input>';
   }
   public function sae_guardar_horario_diferenciado($post_id)
   {
      if (!isset($_POST['horario_diferenciado_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['horario_diferenciado_nonce'], 'horario_diferenciado_nonce')) {
         return;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
      }
      if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
         if (!current_user_can('edit_page', $post_id)) {
            return;
         }
      } else {
         if (!current_user_can('edit_post', $post_id)) {
            return;
         }
      }
      if (!isset($_POST['horario_diferenciado'])) {
         return;
      }
      $horario_diferenciado = sanitize_text_field($_POST['horario_diferenciado']);
      if ($horario_diferenciado == "") {
         $horario_diferenciado = [];
      } else {
         $horario_diferenciado = str_replace("},{", "};{", $horario_diferenciado);
         $horario_diferenciado = explode(";", $horario_diferenciado);
      }
      update_post_meta($post_id, '_horario_diferenciado', $horario_diferenciado);
   }
}
