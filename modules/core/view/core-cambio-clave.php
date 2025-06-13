<?php

/**
 * 
 * Plantilla para cambio de clave
 * 
 * @package: EGC000
 */

?>
<section class="d-flex justify-content-center pt-5">
   <div class="col-sm-8 col-md-6 col-lg-5">
      <form id="cambiar_clave" class="row g-3 needs-validation border border-1 rounded p-3" novalidate>
         <div class="row mb-3">
            <div class="col-11 form-floating border-bottom">
               <input id="clave_actual" name="clave_actual" placeholder="Contraseña Actual" type="password" class="form-control bg-transparent shadow-none rounded-0 border-0" required>
               <label for="clave_actual">Contraseña Actual</label>
               <div class="invalid-feedback">
                  Favor no dejar en blanco.
               </div>
            </div>
            <div class="col-1 d-flex align-items-center ms-0 ps-0 border-bottom">
               <span class="input-group-text bg-transparent border-0" id="ver_clave_actual"><i id="mostrarClaveActual" class="bi bi-eye"></i></i></span>
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-11 form-floating border-bottom">
               <input id="clave_nueva" type="password" class="form-control bg-transparent shadow-none rounded-0 border-0" name="clave_nueva" placeholder="Nueva Contraseña" required>
               <label for="clave_nueva" class="form-label">Nueva Contraseña</label>
               <div class="invalid-feedback">
                  Favor no dejar en blanco.
               </div>
            </div>
            <div class="col-1 d-flex align-items-center col-1 ms-0 ps-0 border-bottom">
               <span id="ver_nueva_clave" class="input-group-text bg-transparent border-0"><i id="mostrarClaveNueva" class="bi bi-eye"></i></span>
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-11 form-floating border-bottom">
               <input id="clave_nueva2" type="password" class="form-control bg-transparent shadow-none rounded-0 border-0" name="clave_nueva2" placeholder="Comprobación" required>
               <label for="clave_nueva2" class="form-label">Comprobación</label>
               <div class="invalid-feedback">
                  Favor no dejar en blanco.
               </div>
            </div>
            <div class="col-1 d-flex align-items-center col-1 ms-0 ps-0 border-bottom">
               <span id="ver_nueva_clave2" class="input-group-text bg-transparent border-0"><i id="mostrarVerificacion" class="bi bi-eye"></i></span>
            </div>
         </div>
         <div class="row mt-5">
            <div class="col text-center form-group mb-3">
               <button name="cambiar_clave" type="submit" class="btn btn-danger">
                  <span class="me-1"><i id="ojo3" class="fa-solid fa-key"></i></span>Cambiar contraseña
               </button>
            </div>
         </div>
         <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('cambiar_clave') ?>">
         <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      </form>
   </div>
</section>