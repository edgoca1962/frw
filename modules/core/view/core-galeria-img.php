<?php

/**
 * Plantilla para una galería de imágenes
 * 
 * @package: WPFRW
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();
?>
<div class="border border-1 p-3 rounded">
   <div class="col d-flex justify-content-center align-items-center my-3">
      <div class="card mb-5">
         <img id="imagennueva" src="<?php echo WPFRW_DIR_URI . '/assets/img/core/wpfrwbg.jpg' ?>" class="object-fit-cover rounded" alt="Imágen del Usuario" style="width: 300px; height: 300px;">
         <div class="card-img-overlay d-flex justify-content-center align-items-center">
            <label class="display-1" for="galeria_imagen"><i class="fa-regular fa-file-image"></i></label>
            <input type="file" name="galeria_imagen" id="galeria_imagen" multiple hidden>
         </div>
      </div>
   </div> <!-- Captura Imagen -->
   <div id="galeria_imagenes" class="row row-cols-auto g-3 border border-1 rounded p-2 pb-3 m-1" style="height:60px;"></div>
   <button id="enviarImg" class="btn btn-warning my-3" type="button">Registrar imágenes</button>
   <input id="nonce" type="hidden" value="<?php echo wp_create_nonce('galeria_imagenes') ?>">
   <input id="endpoint" type="hidden" value="<?php echo admin_url('admin-ajax.php') ?>">
</div>