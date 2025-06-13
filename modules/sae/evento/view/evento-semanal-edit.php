<div id="ocultarnperiodos" class="col-3">
   <div class="d-flex">
      <div class="col form-control border-0 bg-transparent text-white">Cada</div>
      <input type="number" class="form-control col" id="npereventossemana" name="npereventossemana" min="1" max="100" value="<?php echo get_post_meta(get_the_ID(), '_npereventos', true) ?>">
      <div class="col form-control border-0 bg-transparent text-white">semanas</div>
   </div>
</div> <!-- Cantidad períodos -->
<div class="col my-3">
   <div><label class="form-label">Día de la semana</label></div>
   <div>
      <div class="form-check form-check-inline">
         <input class="diasemana form-check-input opsemana" type="checkbox" value="1" <?php echo in_array('1', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
         <label class="form-check-label" for="lunes">Lunes</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="diasemana form-check-input opsemana" type="checkbox" value="2" <?php echo in_array('2', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
         <label class="form-check-label" for="martes">Martes</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="diasemana form-check-input opsemana" type="checkbox" value="3" <?php echo in_array('3', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
         <label class="form-check-label" for="miercoles">Miércoles</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="diasemana form-check-input opsemana" type="checkbox" value="4" <?php echo in_array('4', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
         <label class="form-check-label" for="miercoles">Jueves</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="diasemana form-check-input opsemana" type="checkbox" value="5" <?php echo in_array('5', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
         <label class="form-check-label" for="miercoles">Viernes</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="diasemana form-check-input opsemana" type="checkbox" value="6" <?php echo in_array('6', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
         <label class="form-check-label" for="miercoles">Sábado</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="diasemana form-check-input opsemana" type="checkbox" value="7" <?php echo in_array('7', explode(",", get_post_meta(get_the_ID(), '_diasemanaevento', true))) ? 'checked' : '' ?>>
         <label class="form-check-label" for="miercoles">Domingo</label>
      </div>
   </div>
</div> <!-- día de la semana -->