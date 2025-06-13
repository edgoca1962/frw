<?php

use WPFRW\Modules\Core\Core;

/**
 * 
 * Plantilla para los Blogs
 * 
 * @package WPFRW
 * 
 */

$core = Core::get_instance();
$core->get_atributos();

?>
<div class="col">
   <div class="card border-0 rounded-4 mx-auto" style="max-width: 18rem; height:25rem;">

      <div class="service-card-inner">

         <div class="service-card-front shadow" style="background: url(<?php echo $core->get_atributo('imagen') ?>) no-repeat center /cover;">
            <div class="container mt-3">
               <h5>
                  <a class="text-reset fw-bold" href="<?php echo get_the_permalink(get_the_ID()) . '?pag=' . $core->get_atributo('pag') ?>"><?php the_title() ?></a>
               </h5>
            </div>
         </div>
         <div class="container service-card-back shadow bg-body-tertiary p-3 d-flex flex-column">

            <div class="row">
               <h5>
                  <a class="text-reset fw-bold" href="<?php echo get_the_permalink(get_the_ID()) . '?pag=' . $core->get_atributo('pag') ?>"><?php the_title() ?></a>
               </h5>
            </div>

            <div class="d-flex flex-column justify-content-center flex-grow-1">
               <div class="row">
                  <p><?php echo wp_trim_words(get_the_excerpt(), 20, '[...]') ?></p>
               </div>

               <div class="row overflow-auto" style="max-height: 12rem;">
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
                  <button class="btn border-0 bg-whatsapp" name="whatsapp"><i class="bi bi-whatsapp"></i></button>
                  <?php if ($core->get_atributo('post_abc') === 'todos' || (get_the_author_meta('ID') == get_current_user_id()) && $core->get_atributo('post_abc') === 'propios') : ?>
                     <button id="<?php echo get_the_ID() ?>" type="submit" class="btn btn-outline-warning btn-sm" name="editar_post"><i class="bi bi-pencil-square"></i></button>
                     <button id="<?php echo get_the_ID() ?>" type="submit" class="btn btn-outline-danger btn-sm" name="eliminar_post"><i class="bi bi-trash-fill"></i></i></button>
                  <?php endif; ?>
                  <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('post_abc') ?>">
                  <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                  <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                  <input id="link_<?php echo get_the_ID() ?>" type="hidden" value="<?php echo get_the_permalink(get_the_ID()) ?>">
               </form>
            </div>

         </div>

      </div>

   </div>
</div>