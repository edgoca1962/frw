<?php

/**
 * 
 * Plantilla para excluir fechas o cambiar horario de un evento.
 * 
 * @package: WPFRW
 * 
 */

?>
<!-- <hr class="border border-danger border-2 opacity-100"> -->
<div class="row mb-3">
   <label class="mb-3" for="f_excluida">Excluir Fechas del evento</label>
   <div class="col-6 col-md-3">
      <input id="f_excluida" type="date" class="form-control exclusiones" type="text" min="" max="" value="<?php echo date('Y-m-d') ?>" disabled>
   </div>
   <div class="col">
      <button id="excluir_fecha" type="button" class="btn btn-sm btn-outline-warning" type="button">Excluir Fecha</button>
   </div>
   <div class="row my-3 ">
      <div class="col">
         <div id="f_excluidas" class="row row-cols-auto g-1 border border-1 rounded p-2" style="height: 35px;"></div>
      </div>
   </div>
</div><!-- Exclusión de fechas -->
<div class="row mb-3">
   <label class="mb-3" for="fecha">Cambiar hora inicio y final de una o varias fechas del evento</label>
   <div class="row">
      <div class="col">
         <label for="f_cambio_horario">Fecha</label>
         <input id="f_cambio_horario" type="date" class="form-control exclusiones" min="" max="" value="<?php echo date('Y-m-d') ?>" disabled>
      </div>
      <div class="col">
         <label for="h_inicial_nueva">Nueva Hora Inicial</label>
         <input id="h_inicial_nueva" type="time" class="form-control exclusiones" min="" max="" value="<?php echo date('H:00', strtotime('+1 hour')) ?>" step="900" disabled>
      </div>
      <div class="col">
         <label for="h_final_nueva">Nueva Hora Final</label>
         <input id="h_final_nueva" type="time" class="form-control exclusiones" min="" max="" value="<?php echo date('H:00', strtotime('+2 hour')) ?>" step="900" disabled>
      </div>
      <div class="col d-flex align-items-center mt-3">
         <button id="cambiar_horario" type="button" class="btn btn-sm btn-outline-warning" type="button">Horario Nuevo</button>
      </div>
      <div class="row my-3 mx-0">
         <div class="col p-0">
            <div id="horario_nuevo" class="row row-cols-auto g-1 border border-1 rounded p-2" style="height: 35px;"></div>
         </div>
      </div>
   </div>
</div><!-- Cambio Horario Evento -->
<hr>