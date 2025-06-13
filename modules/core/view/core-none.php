<?php

/**
 * 
 * Plantilla para none
 * 
 * @package WPFRW
 * 
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();

?>
<?php if ($core->get_atributo('post_view')): ?>
   <h3>No hay información registrada</h3>
<?php else: ?>
   <h3>No cuenta con las facultades para ver la información</h3>
<?php endif; ?>