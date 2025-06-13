<?php

/**
 * 
 * Plantilla para el single de un post
 * 
 * @package:WPFRW
 * 
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();

the_title();
the_content();
