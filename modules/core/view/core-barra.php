<?php

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();

?>
<button id="startSimulation" class="btn btn-primary">Iniciar Simulación</button>

<!-- Barra de progreso -->
<div class="progress mt-3" style="height: 25px;">
   <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;">0%</div>
</div>
<script>
   document.getElementById("startSimulation").addEventListener("click", function() {
      let progressBar = document.getElementById("progressBar");
      let progress = 0;

      let interval = setInterval(() => {
         if (progress >= 100) {
            clearInterval(interval);
            progressBar.classList.remove("progress-bar-animated");
            progressBar.classList.add("bg-success");
         } else {
            progress += Math.floor(Math.random() * 10) + 5; // Incremento aleatorio entre 5 y 15
            progress = Math.min(progress, 100); // No pasar del 100%
            progressBar.style.width = progress + "%";
            progressBar.innerText = progress + "%";
         }
      }, 300); // Intervalo de 300ms para simular la carga
   });
</script>