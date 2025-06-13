<?php

/**
 * 
 * Plantilla principal
 * 
 * @package WPFRW
 * 
 * MPA012 - MPA011 OBTIENE EL SALDO SELFORCE
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();

?>
<!DOCTYPE html>
<html class="" data-bs-theme="<?php echo $core->get_atributo('bs-theme') ?>">

<head>
   <meta charset="<?php bloginfo('charset'); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="profile" href="https://gmpg.org/xfn/11">
   <title>Theme Framework</title>
   <?php wp_head(); ?>
</head>

<body class="<?php echo $core->get_atributo('body') ?>">
   <?php wp_body_open() ?>
   <header>
      <?php get_template_part($core->get_atributo('t_banner')) ?>
      <?php get_template_part($core->get_atributo('t_navbar')) ?>
   </header>
   <div class="<?php echo $core->get_atributo('div1') ?>"> <!-- div1 -->
      <div class="<?php echo $core->get_atributo('div2') ?>"> <!-- div2 -->
         <aside class="<?php echo $core->get_atributo('aside1') ?>"> <!-- aside1 -->
            <?php get_template_part($core->get_atributo('t_aside1')) ?>
         </aside>
         <main class="<?php echo $core->get_atributo('main') ?>"> <!-- main -->
            <?php get_template_part($core->get_atributo('t_btnAgregar')) ?>
            <?php if (have_posts() && $core->get_atributo('post_view')) : ?>
               <div class="<?php echo $core->get_atributo('div3') ?>"> <!-- div3 -->
                  <article class="<?php echo $core->get_atributo('article') ?>"> <!-- article -->
                     <?php
                     while (have_posts()) :
                        the_post();
                        get_template_part($core->get_atributo('t_main'));
                        if (is_page()) {
                           the_content();
                        }
                        if ($core->get_atributo('comentarios') && (comments_open() || get_comments_number())) {
                           comments_template();
                        }
                     endwhile;
                     ?>
                  </article>
                  <?php the_posts_pagination(['prev_text' => '&laquo; Anterior', 'mid_size' => 0, 'next_text' => 'Siguiente &raquo;',]) ?>
                  <?php get_template_part($core->get_atributo('t_btnRegresar')) ?>
               </div>
            <?php else : ?>
               <?php get_template_part($core->get_atributo('t_none')) ?>
            <?php endif; ?>
         </main>
         <aside class="<?php echo $core->get_atributo('aside2') ?>"> <!-- aside2 -->
            <?php get_template_part($core->get_atributo('t_aside2')) ?>
         </aside>
      </div>
   </div>
   <footer class="<?php echo $core->get_atributo('footer') ?>">
      <?php get_template_part($core->get_atributo('t_footer')) ?>
   </footer>
   <?php wp_footer() ?>
</body>

</html>