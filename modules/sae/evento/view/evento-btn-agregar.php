<?php

/**
 * 
 * Plantilla para agregar posts
 * 
 * @package: WPFRW
 */


use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();

?>

<?php if ($core->get_atributo('post_abc') === 'todos' || $core->get_atributo('post_abc') === 'propios') : ?>
   <button class="btn btn-warning btn-sm ms-3 mb-5">
      <a class="text-decoration-none text-black" href="<?php echo esc_url(site_url('/evento-agregar')) ?>"><i class="fa-solid fa-calendar-plus"></i> Agregar Evento</a>
   </button>
<?php endif; ?>