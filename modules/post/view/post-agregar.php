<?php

/**
 * 
 * Plantilla para agregar posts
 * 
 * @package:WPFRW
 * 
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();

?>
<?php if ($core->get_atributo('post_abc') === 'todos' || $core->get_atributo('post_abc') === 'propios') : ?>

   <h3>Plantilla para agregar posts</h3>
<?php else: ?>
   <h3>No cuenta con las facultades para agregar artículos.</h3>
<?php endif; ?>