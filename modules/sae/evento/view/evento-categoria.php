<?php

/**
 * 
 * Plantilla para incluir categorías y etiquetas de eventos.
 * 
 * @package WPFRW
 * 
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();
?>
<h5>Asignar Categorías y Etiquetas a Evento</h5>
<div class="row mb-3">
   <div class="row mb-3">
      <div class="col-auto">
         <select class="form-select" id="sel_cat" aria-label="categorias">
            <option value="sel_cat">Escoja una categoría</option>
            <?php foreach (get_terms(['taxonomy' => 'evento_cat', 'hide_empty' => false]) as $categoria) : ?>
               <option><?php echo $categoria->name ?></option>
            <?php endforeach; ?>
         </select>
      </div> <!-- Categorías -->
      <div class="col-auto">
         <button type="button" id="btn_cat" class="btn btn-sm btn-outline-warning">Asignar Categoría</button>
      </div> <!-- Botón para asignar -->
   </div> <!-- Seleccionar y asignar Categorías -->
   <div class="row">
      <div class="col">
         <div id="categorias" class="row row-cols-auto g-1 border border-1 rounded p-2" style="height: 35px;"></div>
      </div>
   </div><!-- Categorías asignadas -->
   <input class="cat_tag" id="evento_cat_dato" type="hidden" name="evento_cat_dato" disabled>
</div> <!-- Asignación de Categorías -->
<div class="row mb-3">
   <div class="row mb-3">
      <div class="col-auto">
         <input class="form-control" type="text" id="evento_tag">
      </div> <!-- Captura de Etiquetas -->
      <div class="col-auto">
         <button type="button" id="btn_tag" class="btn btn-sm btn-outline-warning">Asignar Etiqueta</button>
      </div> <!-- Botón para asignar etiqueitas -->
   </div>
   <div class="row">
      <div class="col">
         <div id="etiquetas" class="row row-cols-auto g-1 border border-1 rounded p-2" style="height: 35px;"></div>
      </div>
   </div> <!-- Etiqueitas Asignadas -->
   <input class="cat_tag" id="evento_tag_dato" type="hidden" name="evento_tag_dato" disabled>
</div> <!-- Asignación de etiqueitas -->