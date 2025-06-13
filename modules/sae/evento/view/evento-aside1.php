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
   <section>
      <div class="row">
         <?php get_template_part($core->get_atributo('evento_calendario')) ?>
         <div class="col">
            <div class="mb-3">
               <h4 class="fw-bold">Categorías</h4>
               <?php wp_list_categories(['taxonomy' => 'evento_cat', 'show_count' => 1, 'title_li' => '']) ?>
            </div>
            <div class="mb-3">
               <h4 class="fw-bold mt-5">Etiquetas</h4>
               <?php wp_tag_cloud(['taxonomy' => ['evento_tag'], 'show_count' => 1]) ?>
            </div>
            <div class="mb-3">
               <!-- <?php wp_get_archives(['evento_type' => 'evento', 'type' => 'monthly']) ?> -->
            </div>
         </div>
      </div>
   </section>