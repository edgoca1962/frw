<div class="row mb-3">
   <div class="form-check form-switch d-flex justify-content-center">
      <input class="form-check-input" type="checkbox" role="switch" id="opcion_mensual" name="opcion_mensual" data-opcion="<?php echo get_post_meta(get_the_ID(), '_opcionesquema', true) ?>" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'checked' : '' ?>>
      <label class="form-check-label ms-2" for="opcion_mensual">Cambio entre opciones de priodicidad mensual</label>
   </div>
</div> <!-- Switch opciones mensuales -->
<div class="row mb-3">
   <div id="opcionmensualuno" class="col">
      <div class="col-xl-6 mb-3">
         <div class="d-flex">
            <div class="col form-control border-0 bg-transparent text-white">Cada</div>
            <input type="number" class="form-control op1mensual <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? '' : 'bg-secondary' ?>" id="npereventosmes1" name="npereventosmes1" min="1" max="100" value="<?php echo get_post_meta(get_the_ID(), '_npereventos', true) ?>" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? '' : 'disabled' ?>>
            <div class="col form-control border-0 bg-transparent text-white">meses</div>
         </div>
      </div> <!-- Cantidad períodos -->
      <div class="col-xl-6 mb-3">
         <label for="numerodiaeventomes" class="form-label">Número del Día</label>
         <input type="number" class="form-control op1mensual <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? '' : 'bg-secondary' ?>" id="numerodiaeventomes" name="numerodiaevento" min="1" max="31" value="<?php echo get_post_meta(get_the_ID(), '_numerodiaevento', true) ?>" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? '' : 'disabled' ?>>
      </div> <!-- Número día del mes -->
   </div> <!-- Primera Opción Mensual -->
   <div id="opcionmensualdos" class="col">
      <div class="col-xl-6 mb-3">
         <div class="d-flex">
            <div class="col form-control border-0 bg-transparent text-white">Cada</div>
            <input type="number" class="form-control op2mensual <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'bg-secondary' : '' ?>" id="npereventosmes2" name="npereventosmes2" min="1" max="100" value="<?php echo get_post_meta(get_the_ID(), '_npereventos', true) ?>" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'disabled' : '' ?>>
            <div class="col form-control border-0 bg-transparent text-white">meses</div>
         </div>
      </div> <!-- Cantidad períodos -->
      <div class="col-xl-6">
         <label class="form-label">Día ordinal</label>
         <select id="numerodiaordinalevento" name='numerodiaordinalevento' class="form-select op2mensual <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'bg-secondary' : '' ?>" aria-label="Seleccionar frecuencia" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'disabled' : '' ?>>
            <option value="1" <?php echo (get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) == '1') ? 'selected' : '' ?>>Primer</option>
            <option value="2" <?php echo (get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) == '2') ? 'selected' : '' ?>>Segundo</option>
            <option value="3" <?php echo (get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) == '3') ? 'selected' : '' ?>>Tercer</option>
            <option value="4" <?php echo (get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) == '4') ? 'selected' : '' ?>>Cuarto</option>
            <option value="5" <?php echo (get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) == '5') ? 'selected' : '' ?>>Último</option>
         </select>
      </div> <!-- Día Ordinal -->
      <div class="col my-3">
         <div><label for="" class="form-label">Día de la semana</label></div>
         <div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual" type="checkbox" value="1" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'disabled' : '' ?> <?php echo in_array('1', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
               <label class="form-check-label" for="lunes">Lunes</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual" type="checkbox" value="2" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'disabled' : '' ?><?php echo in_array('2', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
               <label class="form-check-label" for="martes">Martes</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual" type="checkbox" value="3" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'disabled' : '' ?><?php echo in_array('3', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
               <label class="form-check-label" for="miercoles">Miércoles</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual" type="checkbox" value="4" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'disabled' : '' ?><?php echo in_array('4', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
               <label class="form-check-label" for="miercoles">Jueves</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual" type="checkbox" value="5" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'disabled' : '' ?><?php echo in_array('5', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
               <label class="form-check-label" for="miercoles">Viernes</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual" type="checkbox" value="6" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'disabled' : '' ?><?php echo in_array('6', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
               <label class="form-check-label" for="miercoles">Sábado</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual" type="checkbox" value="7" <?php echo (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') ? 'disabled' : '' ?><?php echo in_array('7', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
               <label class="form-check-label" for="miercoles">Domingo</label>
            </div>
         </div>
      </div> <!-- Día de la semana -->
   </div> <!-- Segunda Opción Mensual -->
</div> <!-- valores opciones mensuales -->