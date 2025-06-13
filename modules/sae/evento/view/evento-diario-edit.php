<div id="ocultarnperiodos" class="col-3">
   <div class="d-flex">
      <div class="col form-control border-0 bg-transparent text-white habilitar">Cada</div>
      <input type="number" class="form-control col" id="npereventosdiario" name="npereventosdiario" min="1" max="100" value="<?php echo get_post_meta(get_the_ID(), '_npereventos', true) ?>" disabled>
      <div class="col form-control border-0 bg-transparent text-white">días</div>
   </div>
</div> <!-- Cantidad períodos -->