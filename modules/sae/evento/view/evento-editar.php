<?php

/**
 * 
 * Plantilla para editar de eventos
 * 
 * @package: WPFRW
 * 
 */

?>
<?php if ($core->get_atributo('post_abc') === 'todos' || $core->get_atributo('post_abc') === 'propios') : ?>
   <form id="evento" enctype="multipart/form-data" class="row g-3 needs-validation mb-5" novalidate style="overflow:hidden;">
      <section class="border border-2 rounded px-5 py-3">
         <div class="row mb-3">
            <div class="col">
               <input id="title" name="title" type="text" class="form-control" placeholder="Título del Evento" value="<?php echo get_the_title() ?>" required>
               <div class="invalid-feedback">
                  Por favor indicar un título para el evento
               </div>
            </div>
         </div> <!-- Título -->
         <div class="row row-cols-1 row-cols-md-2">
            <div class="col-xl-8 mb-3">
               <textarea class="form-control w-100" rows="8" name="content" id="content" placeholder="Descripción del Evento"><?php get_the_content() ?></textarea>
            </div> <!-- descripción del evento -->
            <div class="col-xl-4 mb-3">
               <div class="card text-bg-dark shadow">
                  <img id="imagennueva" src="<?php echo $core->get_atributo('imagen') ?>" class="card-img" style="width: 100%; height: 200px; object-fit: cover;" alt="Imágen del evento">
                  <div class="card-img-overlay d-flex justify-content-center align-items-center">
                     <label class="display-1" for="evento_imagen"><i class="fa-regular fa-file-image"></i></label>
                     <input type="file" name="evento_imagen" id="evento_imagen" multiple="false" hidden>
                  </div>
               </div>
            </div> <!-- imagen del evento -->
         </div> <!-- descripción e imagen del evento -->
         <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3 d-flex align-items-center">
            <div class="col">
               <label class="form-label">Tipo de evento </label>
               <select id="periodicidadevento" name='periodicidadevento' class="form-select" aria-label="Seleccionar frecuencia">
                  <option value="1" <?php echo (get_post_meta(get_the_ID(), '_periodicidadevento', true) == 1) ?  'selected' : '' ?>>Evento único</option>
                  <option value="2" <?php echo (get_post_meta(get_the_ID(), '_periodicidadevento', true) == 2) ?  'selected' : '' ?>>Se repite diariamente</option>
                  <option value="3" <?php echo (get_post_meta(get_the_ID(), '_periodicidadevento', true) == 3) ?  'selected' : '' ?>>Se repite semanalmente</option>
                  <option value="4" <?php echo (get_post_meta(get_the_ID(), '_periodicidadevento', true) == 4) ?  'selected' : '' ?>>Se repite mensualmente</option>
                  <option value="5" <?php echo (get_post_meta(get_the_ID(), '_periodicidadevento', true) == 5) ?  'selected' : '' ?>>Se repite anualmente</option>
               </select>
            </div> <!-- Repetición evento -->
            <div class="col">
               <div class="form-check form-switch mt-4">
                  <input class="form-check-input" type="checkbox" role="switch" id="inscripcion" name="inscripcion" value="<?php echo get_post_meta(get_the_ID(), '_inscripcion', true) ?>" <?php echo (get_post_meta(get_the_ID(), '_inscripcion', true) == 'on') ? 'checked' : '' ?>>
                  <label class="form-check-label" for="inscripcion">Requiere Inscripción</label>
               </div>
            </div> <!-- requiere inscripción -->
            <div class="col">
               <div class="form-check form-switch d-flex my-2">
                  <input class="form-check-input" type="checkbox" role="switch" id="donativo" name="donativo" value="<?php echo get_post_meta(get_the_ID(), '_donativo', true) ?> <?php echo (get_post_meta(get_the_ID(), '_donativo', true) == 'on') ? 'checked' : '' ?>">
                  <label class="form-check-label ps-2" for="donativo">Requiere donativo</label>
               </div>
               <div class="input-group">
                  <span class="input-group-text">₡</span>
                  <input id="montodonativo" name="montodonativo" type="number" class="form-control me-auto" aria-label="Amount" min="0.00" step="1000.00" max="1000000" placeholder="Monto donativo sugerido" value="<?php echo get_post_meta(get_the_ID(), '_donativo', true) ?>" <?php echo (get_post_meta(get_the_ID(), '_montodonativo', true) > 0) ? '' : 'disabled' ?>>
               </div>
            </div> <!-- donativo -->
            <div class="col">
               <div class="form-check form-switch d-flex my-2">
                  <input class="form-check-input" type="checkbox" role="switch" id="aforo" name="aforo" value="<?php echo get_post_meta(get_the_ID(), '_aforo', true) ?> <?php echo (get_post_meta(get_the_ID(), '_aforo', true) == 'on') ? 'checked' : '' ?>">
                  <label class="form-check-label ps-2" for="aforo">Requiere Aforo</label>
               </div>
               <input id="q_aforo" name="q_aforo" type="number" class="form-control me-auto" aria-label="Amount" min="0" max="10000" placeholder="Cantidad Aforo" value="<?php echo get_post_meta(get_the_ID(), '_q_aforo', true) ?>" <?php (get_post_meta(get_the_ID(), '_q_aforo', true) > 0) ?: 'disabled' ?>>
            </div> <!-- Requiere Aforo -->
         </div> <!-- Tipo evento, inscripción, donativo y Aforo -->
         <h4>Horario del evento</h4>
         <div class="row row-cols-1 row-cols-md-2 row-cols-xl-5 mb-3 d-flex align-items-center">
            <div class="col-auto mb-3">
               <label for="f_inicio" class="form-label">Feha Inicial</label>
               <input type="date" class="form-control" id="f_inicio" name="f_inicio" value="<?php echo date('Y-m-d', strtotime(get_post_meta(get_the_ID(), '_f_inicio', true))) ?>" required>
               <div class="invalid-feedback">
                  Favor indicar fecha inicial.
               </div>
            </div> <!-- f_inicio -->
            <div class="col-auto mb-3">
               <label for="f_final" class="form-label">Fecha Final</label>
               <input type="date" class="form-control" id="f_final" name="f_final" value="<?php echo (get_post_meta(get_the_ID(), '_f_final', true) == "") ? "" : date('Y-m-d', strtotime(get_post_meta(get_the_ID(), '_f_final', true))) ?>">
               <div class="invalid-feedback">
                  Favor indicar fecha final.
               </div>
            </div> <!-- f_final -->
            <div class="col-auto mb-3">
               <label for="h_inicio" class="form-label">Hora Inicial</label>
               <input type="time" class="form-control" id="h_inicio" name="h_inicio" value="<?php echo date('H:00', strtotime(get_post_meta(get_the_ID(), '_f_inicio', true))) ?>" step="900">
               <div class="invalid-feedback">
                  Seleccionar hora exacta o facción de 15 min.
               </div>
            </div> <!-- h_inicio -->
            <div class="col-auto mb-3">
               <label for="h_final" class="form-label">Hora Final</label>
               <input type="time" class="form-control" id="h_final" name="h_final" value="<?php echo (get_post_meta(get_the_ID(), '_f_final', true) == "") ? "" : date('H:00', strtotime(get_post_meta(get_the_ID(), '_f_final', true))); ?>" step="900">
               <div class="invalid-feedback">
                  Seleccionar hora exacta o facción de 15 min.
               </div>
            </div> <!-- h_final -->
            <div class="col-auto">
               <div id="diacompleto" class="form-check form-switch mt-xl-3">
                  <input class="form-check-input" type="checkbox" role="switch" id="dia_completo" name="dia_completo" value="<?php echo get_post_meta(get_the_ID(), '_dia_completo', true) ?>" <?php echo (get_post_meta(get_the_ID(), '_dia_completo', true) == 'on') ? 'checked' : '' ?>>
                  <label class="form-check-label" for="dia_completo">Día completo</label>
               </div>
            </div> <!-- dia_completo -->
         </div> <!-- horario del evento -->
         <div class="row mb-3 align-items-center">
            <div class="col-auto pb-md-3">
               <div class="form-check form-switch mt-md-3">
                  <input class="form-check-input" type="checkbox" role="switch" id="evento_virtual" name="evento_virtual" value="<?php echo get_post_meta(get_the_ID(), '_evento_virtual', true) ?>" <?php echo (get_post_meta(get_the_ID(), '_evento_virtual', true) == 'on') ? 'checked' : '' ?>>
                  <label class="form-check-label" for="evento_virtual">Evento virtual</label>
               </div>
            </div> <!-- Encendido -->
            <div class="col-md-6">
               <input class="form-control" type="text" id="enlace_virtual" name="enlace_vitual" placeholder="Enlace del evento virtual" value="<?php echo (get_post_meta(get_the_ID(), '_enlace_virtual', true) == 'on') ? 'checked' : 'disabled hidden' ?>">
            </div> <!-- Enlace -->
            <div id="direccion">
               <div class="col-md-6 mb-3">
                  <input id="d_name" name="d_name" class="form-control" type="text" placeholder="Nombre del lugar..." value="<?php echo get_post_meta(get_the_ID(), '_d_name', true) ?>">
               </div>
               <div class="d-flex justify-content-between" id="search-container">
                  <div class="row w-100">
                     <div class="col-4">
                        <div class="input-group">
                           <input class="form-control" type="text" id="address" name="address" placeholder="Dirección del evento...">
                           <button id="btn_buscar_direccion" type="button" class="btn btn-outline-warning"><i class="bi bi-search"></i></button>
                        </div>
                     </div>
                     <div class="col-3 pe-1">
                        <input id="lat" class="form-control" type="numeric" placeholder="Latitud" value="<?php echo get_post_meta(get_the_ID(), '_latitud', true) ?>">
                     </div>
                     <div class="col-3 px-0">
                        <input id="lon" class="form-control" type="numeric" placeholder="Longitud" value="<?php echo get_post_meta(get_the_ID(), '_longitud', true) ?>">
                     </div>
                     <div class="col-2">
                        <button type="button" class="btn btn-outline-warning" id="btn_lat_lon">Buscar</button>
                     </div>
                  </div>
               </div>
               <input type="hidden" id="latitud" name="latitud" value="<?php echo get_post_meta(get_the_ID(), '_latitud', true) ?>">
               <input type="hidden" id="longitud" name="longitud" value="<?php echo get_post_meta(get_the_ID(), '_longitud', true) ?>">
               <div class="row">
                  <div class="col">
                     <div class="rounded mt-3" id="map" style="height: 400px;"></div>
                  </div>
               </div>
            </div> <!-- Dirección -->
         </div><!-- Evento virtual -->
         <div id="formatos_repeticion" class="row mb-3">
            <!-- <div class="row"> -->
            <section id="unico" hidden>
            </section> <!-- Evento único -->
            <section id="diario" hidden>
               <?php get_template_part($core->get_atributo('evento_diario')) ?>
            </section> <!-- Evento diario -->
            <section id="semanal" hidden>
               <?php get_template_part($core->get_atributo('evento_semanal')) ?>
            </section> <!-- Evento semanal -->
            <section id="mensual" hidden>
               <?php get_template_part($core->get_atributo('evento_mensual')) ?>
            </section> <!-- Evento mensual -->
            <section id="anual" hidden>
               <?php get_template_part($core->get_atributo('evento_anual')) ?>
            </section> <!-- Evento anual -->
            <!-- </div> formatos repeticion por tipo de evento -->
         </div> <!-- Fromatos de periodicidad -->
      </section>

      <!-- voy por aquí -->

      <section class="border border-2 rounded px-5 py-3 mb-3">
         <div class="col col-md-6 col-lg-3">
            <select class="form-select" id="post_author" name="post_author" aria-label="responsable">
               <option>Asignar Responsable</option>
               <?php foreach ($core->get_atributo('roles_eventos') as $usuario) : ?>
                  <option value="<?php echo $usuario->ID ?>" <?php echo (get_current_user_id() == $usuario->ID) ? 'selected' : '' ?>><?php echo $usuario->display_name ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <p>Nota: falta enviar correo al usuario asignado y que sea deistinto al actual</p>
      </section> <!-- Asignar usuario a evento -->
      <section class="border border-2 rounded px-5 py-3 mb-3">
         <div class="row mb-3 d-flex align-items-center">
            <div class="col col-md-8 col-lg-6">
               <div class="form-check form-switch mt-md-3">
                  <input class="form-check-input" type="checkbox" role="switch" id="cambio_horario" name="cambio_horario" value="off" disabled>
                  <label class="form-check-label" for="cambio_horario">Excluir fechas y/o cambiar horario</label>
               </div>
            </div> <!-- cambio horario -->
         </div> <!-- f_final cambio horario -->
         <div id="t_cambio_horario" hidden>
            <?php get_template_part($core->get_atributo('evento_cambiar_horario')) ?>
         </div> <!-- Evento cambio horario -->
      </section> <!-- Excluir fechas o cambiar horarios -->
      <section class="border border-2 rounded px-5 py-3 mb-3">
         <div class="row mb-3 d-flex align-items-center">
            <div class="col col-md-8 col-lg-6">
               <div class="form-check form-switch mt-md-3">
                  <input class="form-check-input" type="checkbox" role="switch" id="evento_cat_tag" name="evento_cat_tag" value="off">
                  <label class="form-check-label" for="evento_cat_tag">Categorizar y Etiquetar Evento</label>
               </div>
            </div> <!-- Categorizar y Etiquetar -->
         </div> <!-- Btn Categorizar y Etiquetar -->
         <div id="t_cat_tag" hidden>
            <?php get_template_part($core->get_atributo('evento_categoria')) ?>
         </div>
      </section> <!-- Asignación de Categorías y Etiqueitas -->
      <div class="col-auto">
         <button id="registrar_evento" name="registrar_evento" class="btn btn-warning" type="submit"><i class="fas fa-save"></i> Registrar evento</button>
      </div> <!-- Botones para acciones -->
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('evento') ?>">
      <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      <input type="hidden" name="post_status" value="<?php echo $core->get_atributo('post_status') ?>">
      <input type="hidden" name="nonce_email" value="<?php echo wp_create_nonce('send_email') ?>">
   </form>
<?php else : ?>
   <h3>No tiene facultades para el agregar eventos</h3>
<?php endif; ?>
<?php
