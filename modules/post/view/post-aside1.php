<?php

use WPFRW\Modules\Core\Core;

/**
 * 
 * Plantilla del aside del Blog
 *
 * @package: WPFRW
 *
 */

$core = Core::get_instance();
$core->get_atributos();

?>
<?php get_template_part($core->get_atributo('t_busquedas')) ?>
<div class="row d-none d-sm-block">
   <div class="col">
      <div class="mb-3">
         <h4 class="fw-bold">Categorías</h4>
         <?php wp_list_categories(['taxonomy' => 'category', 'show_count' => 1, 'title_li' => '']) ?>
      </div>
      <div class="mb-3">
         <h4 class="fw-bold mt-5">Etiquetas</h4>
         <?php wp_tag_cloud(['taxonomy' => ['post_tag'], 'show_count' => 1]) ?>
      </div>
      <div class="mb-3">
         <!-- <?php wp_get_archives(['post_type' => 'evento', 'type' => 'monthly']) ?> -->
      </div>
   </div>
</div>