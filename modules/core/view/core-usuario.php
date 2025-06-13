<?php

/**
 * 
 * Pantalla para manetinimiento de Usuarios
 * 
 * @package WPFRW
 * 
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();

?>
<?php if ($core->get_atributo('admin')) : ?>
   <form id="core_usuario" enctype="multipart/form-data" class="needs-validation border border-1 rounded p-3" novalidate>
      <div class="col d-flex justify-content-center align-items-center my-3">
         <div class="card">
            <img id="imagennueva" src="<?php echo WPFRW_DIR_URI . '/assets/img/core/wpfrwusr.png' ?>" class="object-fit-cover rounded" alt="Imágen del Usuario" style="width: 200px;">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
               <label class="display-1" for="usuario_imagen"><i class="fa-regular fa-file-image"></i></label>
               <input type="file" name="usuario_imagen" id="usuario_imagen" multiple="false" hidden>
            </div>
         </div>
      </div> <!-- Imagen Usuario -->
      <div class="row row-cols-md-3 g-3 mb-3">
         <div class="col-md">
            <label for="user_email" class="form-label">E-mail</label>
            <input id="user_email" name="user_email" type="email" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco y en formato de email.
            </div>
         </div>
         <div class="col-md">
            <label for="first_name" class="form-label">Nombre</label>
            <input id="first_name" name="first_name" type="text" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco.
            </div>
         </div>
         <div class="col-md">
            <label for="last_name" class="form-label">Apellido</label>
            <input id="last_name" name="last_name" type="text" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco.
            </div>
         </div>
         <div class="col-md">
            <label for="user_login" class="form-label">Usuario de ingreso</label>
            <input id="user_login" name="user_login" type="text" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco.
            </div>
         </div>
         <div class="col-md">
            <label for="user_pass" class="form-label">Contraseña</label>
            <input id="user_pass" name="user_pass" type="text" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco.
            </div>
         </div>
      </div> <!-- Datos Usuario -->
      <div class="row row-cols-md-3 g-3 mb-3">
         <div class="col mb-3">
            <select class="form-select me-auto" name="roles" id="roles">
               <option value="">Seleccionar Roles</option>
               <?php foreach ($core->get_atributo('roles') as $role => $nombre) : ?>
                  <option value="<?php echo $role ?>"><?php echo $nombre ?></option>
               <?php endforeach; ?>
            </select>
         </div> <!-- roles Usuario -->
         <div class="col">
            <button id="asignar_rol" type="button" class="btn btn-warning btn-sm">Asignar Rol</button>
         </div>
      </div> <!-- Select de Roles -->
      <div class="row row-cols-auto g-1 border border-1 rounded p-2" id="roles_usuario" style="height: 35px;"></div> <!-- Roles Asignados -->
      <div class="d-flex justify-content-center mt-3">
         <div class="">
            <button id="agregar_usuario" name="agregar_usuario" type="submit" class="btn btn-warning disabled"><i class="fa-solid fa-user-plus"></i> Agregar</button>
            <button id="modificar_usuario" name="modificar_usuario" type="submit" class="btn btn-warning mx-3 disabled"><i class="fa-solid fa-user-pen"></i> Modificar</button>
            <button id="eliminar_usuario" name="eliminar_usuario" type="submit" class="btn btn-danger disabled"><i class="fa-solid fa-user-minus"></i> Eliminar</button>
         </div>
         <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('core_usuario') ?>">
         <input type="hidden" name="endpoint" id="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
         <input type="hidden" name="url" id="url_usuario" value="<?php echo get_site_url() . '/wp-json/wp/v2/users' ?>">
         <input type="hidden" name="user_id" id="usuario_id">
      </div> <!-- Botones submit -->
   </form>
<?php else : ?>
   <h3>No tiene facultades para el mantenimiento de usuarios</h3>
<?php endif; ?>