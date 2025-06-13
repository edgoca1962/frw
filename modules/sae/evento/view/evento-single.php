<?php

/**
 * 
 * Plantilla para mostrar la información de un evento
 * 
 * @package:WPFRW
 * 
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();
?>

<?php the_content() ?>
