<?php

/**
 * 
 * Login Template
 * 
 * @package: WPFRW
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
?>
<?php if (!is_user_logged_in()) : ?>
   <section style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(<?php echo $core->get_atributo('imagen_banner') ?>) no-repeat center /cover; height: <?php echo $core->get_atributo('height') ?>;">
      <div class="col d-flex align-items-center justify-content-center h-100">
         <form class="needs-validation float ingreso-bg p-5 border-0 shadow" id="ingreso" novalidate style="width: 18rem;" data-bs-theme="dark">
            <div class="d-flex justify-content-center">
               <a href="<?php echo esc_url(site_url('/')) ?>" style="z-index:5; margin-top:-5.25rem;">
                  <img class="<?php echo $core->get_atributo('classLogo') ?>" style="width: 75px; height:auto;" src="<?php echo $core->get_atributo('wplogo') ?>" alt="Logo">
               </a>
            </div>
            <div class="form-floating mb-3 border-bottom">
               <input type="text" class="form-control bg-transparent border-0 shadow-none" id="usuario" name="usuario" placeholder="usuario" required>
               <label for="usuario">Usuario</label>
            </div>
            <div class="d-flex form-floating mb-3 border-bottom">
               <input type="password" class="form-control bg-transparent border-0 shadow-none" id="clave" name="clave" placeholder="contraseña" required>
               <label for="clave">Contraseña </label>
               <span class="mt-4"><i id="mostrar" class="bi bi-eye"></i></span>
            </div>
            <div class="mb-4">
               <input class="form-check-input" type="checkbox" value="" id="recordarme">
               <label class="form-check-label fw-light" for="recordarme">Recordarme</label>
            </div>
            <div class="text-center form-group">
               <button type="submit" name="ingresar" class="btn btn-warning btn-sm mb-3"><i class="bi bi-box-arrow-in-right"></i>
                  Ingresar</button>
            </div>
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('frm_ingreso') ?>">
            <input type="hidden" name="redireccion" value="<?php echo site_url($core->get_atributo('redireccion')) ?>">
            <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
         </form>
      </div>
   </section>
<?php else : ?>
   <?php $core->set_atributo('titulo', 'Ya se encuentra ingresado') ?>
<?php endif; ?>