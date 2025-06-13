<?php

/**
 * 
 * Plantilla Banner
 * 
 * @package WPFRW
 * 
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();

?>

<section id="hero-page" class="d-flex flex-column justify-content-center align-items-center text-white" style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(<?php echo $core->get_atributo('imagen_banner') ?>) no-repeat center /cover; height: <?php echo $core->get_atributo('height') ?>;">
   <p class="animate__animated animate__fadeInDown mb-3 text-center  <?php echo $core->get_atributo('fontweight') ?>  <?php echo $core->get_atributo('display') ?>"><?php echo $core->get_atributo('titulo') ?></p>
   <p class="animate__animated animate__fadeInUp mb-3 text-center <?php echo $core->get_atributo('fontweight') ?>  <?php echo $core->get_atributo('displaysub') ?>"><?php echo $core->get_atributo('subtitulo') ?></p>
   <p class="animate__animated animate__fadeInUp text-center  <?php echo $core->get_atributo('fontweight') ?>  <?php echo $core->get_atributo('displaysub2') ?>"><?php echo  $core->get_atributo('subtitulo2') ?></p>
</section>