<?php

/**
 * Sidebar de eventos
 * 
 * @package sae
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();

?>


<div class="col mb-3">
   <div class="position-relative">
      <form id="frmbuscar">
         <input id="impbuscar" class="form-control" type="text" placeholder="Buscar Evento" aria-label="Search">
      </form>
      <div id="resultados" class="container invisible position-absolute search-overlay bg-body-tertiary rounded w-100" style="height:300px;">
         <div class="d-flex justify-content-between">
            <h5>Resultados</h5><span id="btn_cerrar"><i class="far fa-times-circle"></i></span>
         </div>
         <div id="resultados_busqueda" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/eventos?search=' ?>" data-msg="No se encontraron Eventos"></div>
      </div>

   </div>
</div>
<section id="calendario">
   <div class="row mb-3">
      <div class="col">
         <select id="recurrencia" class="form-select" aria-label="Seleccionar recurrencia">
            <option value="6" selected>Seleccionar Recurrencia</option>
            <option value="1" <?php echo $core->get_atributo('recurrencia') == 1 ? 'selected' : '' ?>>Evento único</option>
            <option value="2" <?php echo $core->get_atributo('recurrencia') == 2 ? 'selected' : '' ?>>Recurrencia diaria</option>
            <option value="3" <?php echo $core->get_atributo('recurrencia') == 3 ? 'selected' : '' ?>>Recurrencia semanal</option>
            <option value="4" <?php echo $core->get_atributo('recurrencia') == 4 ? 'selected' : '' ?>>Recurrencia mensual</option>
            <option value="5" <?php echo $core->get_atributo('recurrencia') == 5 ? 'selected' : '' ?>>Recurrencia anual</option>
         </select>
      </div>
   </div>
   <div class="row">
      <div class="col-6">
         <select id="mesEvento" class="form-select" name="">
            <option value="January" <?php echo ($core->get_atributo('mes') === "January") ? 'selected' : '' ?>>Enero</option>
            <option value="February" <?php echo ($core->get_atributo('mes') === "February") ? 'selected' : '' ?>>Febrero</option>
            <option value="March" <?php echo ($core->get_atributo('mes') === "March") ? 'selected' : '' ?>>Marzo</option>
            <option value="April" <?php echo ($core->get_atributo('mes') === "April") ? 'selected' : '' ?>>Abril</option>
            <option value="May" <?php echo ($core->get_atributo('mes') === "May") ? 'selected' : '' ?>>Mayo</option>
            <option value="June" <?php echo ($core->get_atributo('mes') === "June") ? 'selected' : '' ?>>Junio</option>
            <option value="July" <?php echo ($core->get_atributo('mes') === "July") ? 'selected' : '' ?>>Julio</option>
            <option value="August" <?php echo ($core->get_atributo('mes') === "August") ? 'selected' : '' ?>>Agosto</option>
            <option value="September" <?php echo ($core->get_atributo('mes') === "September") ? 'selected' : '' ?>>Septiembre</option>
            <option value="October" <?php echo ($core->get_atributo('mes') === "October") ? 'selected' : '' ?>>Octubre</option>
            <option value="November" <?php echo ($core->get_atributo('mes') === "November") ? 'selected' : '' ?>>Noviembre</option>
            <option value="December" <?php echo ($core->get_atributo('mes') === "December") ? 'selected' : '' ?>>Diciembre</option>
         </select>
         <input type="hidden" id="url" value=<?php echo get_post_type_archive_link('evento') ?>>
      </div>
      <div class="col-6">
         <input class="form-control" type="number" name="" id="annoEvento" value="<?php echo isset($_GET['anno']) ? sanitize_text_field($_GET['anno']) : date('Y') ?>">
      </div>
   </div>
   <div class="row my-3">
      <div class="table-responsive">
         <table class="table table-dark">
            <thead>
               <tr>
                  <th class="text-center" scope="col">L</th>
                  <th class="text-center" scope="col">K</th>
                  <th class="text-center" scope="col">M</th>
                  <th class="text-center" scope="col">J</th>
                  <th class="text-center" scope="col">V</th>
                  <th class="text-center" scope="col">S</th>
                  <th class="text-center" scope="col">D</th>
               </tr>
            </thead>
            <tbody id="cuerpoCalendario">
               <?php for ($semana = 1; $semana < 8; $semana++) : ?>
                  <?php if ($semana == 1) : ?>
                     <tr>
                        <?php if ($core->get_atributo('espacios') > 0) : ?>
                           <td colspan="<?php echo $core->get_atributo('espacios') ?>"></td>
                        <?php endif; ?>
                        <?php for ($dia = 1; $dia < $core->get_atributo('restante'); $dia++) : ?>
                           <td class=" text-center">
                              <a href=" <?php echo get_post_type_archive_link('evento') . '?cpt=evento&fpe=' . date('Ymd', strtotime($dia . $core->get_atributo('mes') . $core->get_atributo('anno'))) . '&recurrencia=' . $core->get_atributo('recurrencia') . '&mes=' . $core->get_atributo('mes') . '&anno=' . $core->get_atributo('anno') ?>">
                                 <span class="<?php echo (date('Ymd') == date('Ymd', strtotime($dia . $core->get_atributo('mes') . $core->get_atributo('anno')))) ? 'badge rounded-pill text-bg-danger' : '' ?>"><?php echo $dia ?></span>
                              </a>
                           </td>
                        <?php endfor; ?>
                     </tr>
                  <?php else : ?>
                     <tr>
                        <?php for ($diasemana = 1; $diasemana < 8; $diasemana++) : ?>
                           <?php if ($dia < date('j', strtotime('last day of ' . $core->get_atributo('mes')))) : ?>
                              <td class="text-center">
                                 <a href=" <?php echo get_post_type_archive_link('evento') . '?cpt=evento&fpe=' . date('Ymd', strtotime($dia . $core->get_atributo('mes') . $core->get_atributo('anno'))) . '&recurrencia=' . $core->get_atributo('recurrencia') . '&mes=' . $core->get_atributo('mes') . '&anno=' . $core->get_atributo('anno')  ?>">
                                    <span class="<?php echo (date('Ymd') == date('Ymd', strtotime($dia . $core->get_atributo('mes') . $core->get_atributo('anno')))) ? 'badge rounded-pill text-bg-danger' : '' ?>"><?php echo $dia++ ?></span>
                                 </a>
                              </td>
                           <?php else : ?>
                              <?php if ($dia == date('j', strtotime('last day of ' . $core->get_atributo('mes')))) : ?>
                                 <td class="text-center">
                                    <a href=" <?php echo get_post_type_archive_link('evento') . '?cpt=evento&fpe=' . date('Ymd', strtotime($dia . $core->get_atributo('mes') . $core->get_atributo('anno'))) . '&recurrencia=' . $core->get_atributo('recurrencia') . '&mes=' . $core->get_atributo('mes') . '&anno=' . $core->get_atributo('anno')  ?>">
                                       <span class="<?php echo (date('Ymd') == date('Ymd', strtotime($dia . $core->get_atributo('mes') . $core->get_atributo('anno')))) ? 'badge rounded-pill text-bg-danger' : '' ?>"><?php echo $dia++ ?></span>
                                    </a>
                                 </td>
                                 <?php if (7 - $diasemana > 0) :  ?>
                                    <td colspan="<?php echo 7 - $diasemana ?>"></td>
                                 <?php endif; ?>
                              <?php endif; ?>
                           <?php endif; ?>
                        <?php endfor; ?>
                     </tr>
                  <?php endif; ?>
               <?php endfor; ?>
            </tbody>
         </table>
      </div>
   </div>
</section>