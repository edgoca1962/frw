<?php

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();

$codInd = ['317', '318'];
$f_inicio = date("d/m/Y", strtotime('2025-03-01'));
$f_final = date("d/m/Y", strtotime('2025-03-23'));

foreach ($codInd as $codigo) {
   $tipoCambio = $core->get_tipo_cambio($codigo, $f_inicio, $f_final);
   foreach ($tipoCambio as $dato) {
      echo date('Y-m-d', strtotime($dato['fecha'])) . '  -  ' . $dato['valor'] . '<br>';
   }
}
