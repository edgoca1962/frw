<?php

use WPFRW\Modules\Core\Core;
use WPFRW\Modules\Sae\Evento\Evento;

/**
 * 
 * Plantilla para los Eventos
 * 
 * @package WPFRW
 * 
 */

$core = Core::get_instance();
$core->get_atributos();
$evento = Evento::get_instance();

?>
<div id="<?php echo get_the_ID() ?>" class="evento col d-flex justify-content-center">
   <div class="card h-100 border-0 shadow">
      <img src="<?php echo $core->get_atributo('imagen')  ?>" class="card-img-top" alt="Imágen Evento">
      <div class="card-body">
         <h5 class="card-title fw-bold">
            <a class="text-reset" href="<?php echo get_the_permalink(get_the_ID()) . '?pag=' . $core->get_atributo('pag') ?>"><?php echo get_the_title() ?></a><span class="text-danger"><?php echo ' ' . $evento->get_atributo('f_cancelada') ?></span>
         </h5>
         <h5 class="text-danger"><?php ?> </h5>
         <h6>Fecha Próxima: <?php echo $core->get_f_tra(date('d-m-Y', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true))), 'EEEE, d \'de\' MMMM yy') ?> a las <?php echo date('H:i', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true))) ?></h6>
         <h6 class="card-subtitle mb-2 text-muted "></h6>
         <p class="card-text"><?php the_excerpt() ?></p>
      </div>
      <div class="ps-3 mb-3">
         <div class="row mb-3">
            <?php if ($core->get_atributo('categorias')) : ?>
               <div class="col text-sm text-secondary">
                  <span>Categorías:</span>
                  <?php foreach ($core->get_atributo('categorias') as $categoria) : ?>
                     <a class="text-reset" href="<?php echo $categoria['enlace'] ?>"><?php echo $categoria['nombre'] ?></a>
                  <?php endforeach; ?>
               </div>
            <?php endif; ?>
         </div>
         <div class="row mb-3">
            <?php if ($core->get_atributo('etiquetas')) : ?>
               <div class="col text-sm text-secondary">
                  <span>Etiquetas:</span>
                  <?php foreach ($core->get_atributo('etiquetas') as $etiqueta) : ?>
                     <a class="text-reset" href="<?php echo $etiqueta['enlace'] ?>"><?php echo $etiqueta['nombre'] ?></a>
                  <?php endforeach; ?>
               </div>
            <?php endif; ?>
         </div>
         <a type="button" class="btn btn-primary" href="<?php echo 'https://waze.com/ul?ll=' . get_post_meta(get_the_ID(), '_latitud', true) . ',' . get_post_meta(get_the_ID(), '_longitud', true) . '&navigate=yes' ?>"><i class="fa-brands fa-waze"></i></a>
      </div>
      <div class=" card-footer">
         <div class="row">
            <div class="col">
               <form id="btns_<?php echo get_the_ID() ?>">
                  <button id="<?php echo get_the_ID() ?>" class="btn border-0 bg-whatsapp" name="whatsapp"><i class="bi bi-whatsapp"></i></button>
                  <?php if ($core->get_atributo('post_abc') === 'todos' || (get_the_author_meta('ID') == get_current_user_id()) && $core->get_atributo('post_abc') === 'propios') : ?>
                     <button id="<?php echo get_the_ID() ?>" type="submit" class="btn btn-outline-warning btn-sm" name="editar_evento"><i class="bi bi-pencil-square"></i></button>
                     <button id="<?php echo get_the_ID() ?>" type="submit" class="btn btn-outline-danger btn-sm" name="eliminar_evento"><i class="bi bi-trash3"></i></button>
                  <?php endif; ?>
                  <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('evento_abc') ?>">
                  <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                  <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                  <input id="link_<?php echo get_the_ID() ?>" type="hidden" value="<?php echo get_the_permalink(get_the_ID()) ?>">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>