<?php

/**
 * Plantilla para comentarios
 *
 * Esta plantilla se puede personalizar por módulo.
 *
 * @package WPFRW
 * @subpackage Core
 * 
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();

get_template_part($core->get_atributo('t_comments'));
