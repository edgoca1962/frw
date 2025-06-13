<?php
// WPFRW_DIR_URI . '/assets/img/wpfrwlogoblanco.png'  : WPFRW_DIR_URI . '/assets/img/wpfrwlogonegro.png'
/**
 * 
 * Plantilla para el NavBar
 * 
 * @package WPFRW
 * 
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();

?>


<nav id="main_navbar" class="navbar fixed-top navbar-expand-lg bg-body-tertiary scroll bg-opacity-10" style="<?php echo $core->get_atributo('navBarStyle') ?>">
   <div id="contenedor" class="container-fluid p-0 m-0">
      <div id="logo" class="navbar-brand logo">
         <div class="d-flex justify-content-center">
            <a href="<?= esc_url(site_url('/')) ?>">
               <img id="imglogo" class="scroll <?php echo $core->get_atributo('classLogo') ?>" style="width: <?php echo $core->get_atributo('logoSize') ?>; height:auto;" src="<?php echo ($core->get_atributo('bs-theme') == 'dark') ? $core->get_atributo('logo')['wpfrwlogoblanco'] : $core->get_atributo('logo')['wpfrwlogonegro']  ?>" alt="Logo">

            </a>
         </div>
      </div>
      <a class="navbar-brand" href="<?= esc_url(site_url('/')) ?>">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="justify-content-end collapse navbar-collapse" id="navbarSupportedContent">
         <!-- <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
               <a class="nav-link active" aria-current="page" href="<?= esc_url(site_url('/')) ?>">Home</a>
            </li>
         </ul> -->
         <?php
         if (is_user_logged_in()) {
            wp_nav_menu(
               array(
                  'theme_location' => 'principal',
                  'container' => false,
                  'menu_class' => 'nav navbar-nav ms-auto mb-2 mb-lg-0',
                  'walker' => new Walker_Nav_Primary()
               )
            );
         }
         if ($core->get_atributo('admin')) {
            wp_nav_menu(
               array(
                  'theme_location' => 'administrador',
                  'container' => false,
                  'menu_class' => 'nav navbar-nav mb-2 mb-lg-0',
                  'walker' => new Walker_Nav_Primary()
               )
            );
         }

         ?>
         <div id="btn_menu" class="navbar nav-item ms-2">
            <div class="btn-group" role="group" aria-label="Avatar">
               <?php if (is_user_logged_in()) : ?>
                  <button type="button" class="btn btn-warning btn-sm"><img class="rounded-circle" src="<?php echo $core->get_atributo('avatar') ?>" style="width:auto; height:25px" alt=""></button>
               <?php endif; ?>
               <button type=" button" class="btn btn-sm btn-warning">
                  <?php if (is_user_logged_in()) : ?>
                     <a class="nav-link text-dark" aria-current="page" href="<?= wp_logout_url('/') ?>"></span><i class="bi bi-box-arrow-in-left"></i> Salir</a>
                  <?php else : ?>
                     <a class="nav-link text-dark" aria-current="page" href="<?= esc_url(site_url('/core-login')) ?>"><i class="bi bi-box-arrow-in-right"></i> Ingresar</a>
                  <?php endif ?>
               </button>
            </div>
         </div>

      </div>
   </div>
</nav>