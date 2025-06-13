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
<div class="col">
   <div id="<?php echo get_the_ID() ?>" class="card border-0 rounded-4 mx-auto" style="max-width: 18rem; height:25rem;">
      <div class="service-card-inner">
         <div class="service-card-front shadow" style="background: url(<?php echo $core->get_atributo('imagen') ?>) no-repeat center /cover;"></div>
         <div class="container service-card-back shadow bg-body-tertiary p-3 d-flex flex-column">
            <div class="row">
               <h5 class="card-title fw-bold">
                  <a class="text-reset" href="<?php echo get_the_permalink(get_the_ID()) . '?pag=' . $core->get_atributo('pag') ?>"><?php echo get_the_title() ?></a><span class="text-danger"><?php echo ' ' . $evento->get_atributo('f_cancelada') ?></span>
               </h5>
               <h5 class="text-danger"><?php ?> </h5>
               <div class="row">
                  <h5 class="fw-bold"><?php echo $core->get_f_tra(date('d-m-Y', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true))), 'EEEE, d \'de\' MMMM') ?> a las <?php echo date('H:i', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true))) ?></h5>
               </div>
            </div>
            <div class="d-flex flex-column justify-content-center flex-grow-1">
               <div class="row overflow-auto" style="max-height: 10rem;">
                  <p><small><?php echo $evento->get_descripcion_evento(get_the_ID()) ?></small></p>
                  <!-- <p><?php echo wp_trim_words(get_the_excerpt(), 20, '[...]') ?></p> -->
               </div>
               <div class="row overflow-auto" style="max-height: 10rem;">
                  <div class="row">
                     <?php if ($core->get_atributo('categorias')) : ?>
                        <div class="col text-sm text-secondary">
                           <span>Categorías:</span>
                           <?php foreach ($core->get_atributo('categorias') as $categoria) : ?>
                              <a class="text-reset" href="<?php echo $categoria['enlace'] ?>"><?php echo $categoria['nombre'] ?></a>
                           <?php endforeach; ?>
                        </div>
                     <?php endif; ?>
                  </div>
                  <div class="row">
                     <?php if ($core->get_atributo('etiquetas')) : ?>
                        <div class="col text-sm text-secondary">
                           <span>Etiquetas:</span>
                           <?php foreach ($core->get_atributo('etiquetas') as $etiqueta) : ?>
                              <a class="text-reset" href="<?php echo $etiqueta['enlace'] ?>"><?php echo $etiqueta['nombre'] ?></a>
                           <?php endforeach; ?>
                        </div>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
            <div class="row mt-auto">
               <form id="btns_<?php echo get_the_ID() ?>">
                  <button id="<?php echo get_the_ID() ?>" class="btn border-0 bg-whatsapp" name="whatsapp"><i class="bi bi-whatsapp"></i></button>
                  <a type="button" class="btn btn-primary" href="<?php echo 'https://waze.com/ul?ll=' . get_post_meta(get_the_ID(), '_latitud', true) . ',' . get_post_meta(get_the_ID(), '_longitud', true) . '&navigate=yes' ?>"><i class="fa-brands fa-waze"></i></a>
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