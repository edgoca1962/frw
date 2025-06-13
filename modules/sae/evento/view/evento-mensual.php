<div class="row mb-3">
   <div class="form-check form-switch d-flex justify-content-center">
      <input class="form-check-input habilitar mensual" type="checkbox" role="switch" id="opcion_mensual" name="opcion_mensual" value="off" disabled>
      <label class="form-check-label ms-2" for="opcion_mensual">Cambio entre opciones de priodicidad mensual</label>
   </div>
</div> <!-- Switch opciones mensuales -->
<div class="row mb-3">
   <div id="opcionmensualuno" class="col">
      <div class="col-xl-6 mb-3">
         <div class="col input-group">
            <span class="input-group-text">Cada</span>
            <input type="number" class="form-control op1mensual habilitar mensual" id="npereventosmes1" name="npereventosmes1" min="1" max="100" value="1" disabled>
            <span class="input-group-text">mes</span>
         </div>
      </div> <!-- Cantidad períodos -->
      <div class="col-xl-6 mb-3">
         <label for="numerodiaeventomes" class="form-label">Número del Día</label>
         <input type="number" class="form-control op1mensual habilitar mensual" id="numerodiaeventomes" name="numerodiaevento" min="1" max="31" value="1" disabled>
      </div> <!-- Número día del mes -->
   </div> <!-- Primera Opción Mensual -->
   <div id="opcionmensualdos" class="col">
      <div class="col-xl-6 mb-3">
         <div class="col input-group">
            <span class="input-group-text">Cada</span>
            <input type="number" class="form-control bg-secondary op2mensual habilitar" id="npereventosmes2" name="npereventosmes2" min="1" max="100" value="1" disabled>
            <span class="input-group-text">mes</span>
         </div>
      </div> <!-- Cantidad períodos -->
      <div class="col-xl-6">
         <label class="form-label">Día ordinal</label>
         <select id="numerodiaordinalevento" name='numerodiaordinalevento' class="form-select op2mensual bg-secondary habilitar" aria-label="Seleccionar frecuencia" disabled>
            <option value="1" selected>Primer</option>
            <option value="2">Segundo</option>
            <option value="3">Tercer</option>
            <option value="4">Cuarto</option>
            <option value="5">Último</option>
         </select>
      </div> <!-- Día Ordinal -->
      <div class="col my-3">
         <div><label for="" class="form-label">Día de la semana</label></div>
         <div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual habilitar" name="diasemanames[]" type="checkbox" value="1" disabled>
               <label class="form-check-label" for="lunes">Lunes</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual habilitar" name="diasemanames[]" type="checkbox" value="2" disabled>
               <label class="form-check-label" for="martes">Martes</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual habilitar" name="diasemanames[]" type="checkbox" value="3" disabled>
               <label class="form-check-label" for="miercoles">Miércoles</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual habilitar" name="diasemanames[]" type="checkbox" value="4" disabled>
               <label class="form-check-label" for="miercoles">Jueves</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual habilitar" name="diasemanames[]" type="checkbox" value="5" disabled>
               <label class="form-check-label" for="miercoles">Viernes</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual habilitar" name="diasemanames[]" type="checkbox" value="6" disabled>
               <label class="form-check-label" for="miercoles">Sábado</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2mensual habilitar" name="diasemanames[]" type="checkbox" value="7" disabled>
               <label class="form-check-label" for="miercoles">Domingo</label>
            </div>
         </div>
      </div> <!-- Día de la semana -->
   </div> <!-- Segunda Opción Mensual -->
</div> <!-- valores opciones mensuales -->