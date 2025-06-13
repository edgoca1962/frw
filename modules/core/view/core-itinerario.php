<?php

/**
 * Plantilla para un Itineario de viaje
 * 
 * @package: WPFRW
 */

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();
$core->get_atributos();
?>
<!-- 
 vuelo: <i class="fa-solid fa-plane-departure"></i>
 Hospedaje: <i class="fa-solid fa-bed"></i>
 Tour: <i class="fa-solid fa-map-location-dot"></i>
 Tren: <i class="fa-solid fa-train"></i>
 Barco: <i class="fa-solid fa-ferry"></i>
 Autobus: <i class="fa-solid fa-bus"></i>
 Vehículo: <i class="fa-solid fa-car-side"></i>
 Flecha abajo: <i class="bi bi-arrow-down"></i>
 Flecha abajo:<i class="fa-solid fa-arrow-down"></i>

 Caminar: <i class="fa-solid fa-person-walking"></i>
 Senderismo: <i class="fa-solid fa-person-hiking"></i>
 Bicicleta: <i class="fa-solid fa-person-biking"></i>
 Motocicleta: <i class="fa-solid fa-motorcycle"></i>
 cable-car: <i class="fa-solid fa-cable-car"></i>
 Helicoptero: <i class="fa-solid fa-helicopter"></i>

-->

<!-- Itinerario -->
<div class="row">
   <div class="row">
      <h3 class=" fw-bold ">Día 1: <span><?php echo $core->get_f_tra(date('Y-m-d', strtotime('2025-10-02')), 'EEEE, d \'de\' MMMM \'del\' y') ?></span></h3>
   </div>
   <div class="col-2 text-center">
      <div class="position-relative border border-5 border-white opacity-100 h-100 vr">
         <div class="d-flex justify-content-center">
            <div class="bg-orange-500 rounded-circle p-2 position-absolute fs-4 text-black border border-white border-2" style="height: 50px; width:50px; margin-top:-6px;">
               <i class="fa-solid fa-plane-departure"></i>
            </div>
         </div>
      </div>
   </div> <!-- Barra Lateral -->
   <div class="col-10 mb-5">
      <div class="row mb-3">
         <h3>San José - Zurich</h3>
      </div>
      <div class="row">
         <h4>
            <p><a class="text-reset" href="#">Ver vuelo</a></p>
            Vuelo: LX8034<br />Fecha Salida: 2025-10-01<br />Hora: 19:40 Ciudad: San José<br />
            Vuelo: LX8045<br />Fecha Llegada: 2025-10-02<br /> Hora 13:25 Ciudad: Zurich<br />
         </h4>
      </div>
   </div> <!-- Información del día -->
</div>
<div class="row">
   <div class="col-2 text-center">
      <div class="position-relative border border-5 border-white opacity-100 h-100 vr">
         <div class="d-flex justify-content-center">
            <div class="bg-orange-500 rounded-circle p-2 position-absolute fs-4 text-black" style="height: 50px; width:50px; margin-top:-6px;">
               <i class="fa-solid fa-car-side"></i>
            </div>
         </div>
      </div>
   </div> <!-- Barra Lateral -->
   <div class="col-10 mb-5">
      <div class="row mb-3">
         <h3 class="fw-bold">Alquiler de vehículo</h3>
      </div>
      <div class="row">
         <h4>
            <p></p><a class="text-reset" href="#">Enlace al Sitio</a></p>
            Agencia: Hertz<br />
            Tipo Vehículo: HONDA HR-V
            Ciudad de recogida: Zurich<br />
            Del: 2025-10-02 Hora: 19:00<br />
            Al: 2025-10-08 Hora: 10:00<br />
            Ciudad de devolución: Zurich
         </h4>
      </div>
   </div> <!-- Información del Tour -->
</div>
<div class="row">
   <div class="col-2 text-center">
      <div class="position-relative border border-5 border-white opacity-100 h-100 vr">
         <div class="d-flex justify-content-center">
            <div class="bg-orange-500 rounded-circle p-2 position-absolute fs-4 text-black" style="height: 50px; width:50px; margin-top:-6px;">
               <i class="fa-solid fa-ferry"></i>
            </div>
         </div>
      </div>
   </div> <!-- Barra Lateral -->
   <div class="col-10 mb-5">
      <div class="row mb-3">
         <h3 class="fw-bold">Tour Lago</h3>
      </div>
      <div class="row">
         <h4>
            <p></p><a class="text-reset" href="#">Enlace al tour</a></p>
            Ciudad: Zurich<br />
            Nombre Hospedaje: Hotel Altstadt<br />
            Ingreso: 2025-10-02 Salida: 2025-10-03
         </h4>
      </div>
   </div> <!-- Información del Tour -->
</div>
<div class="row">
   <div class="col-2 text-center">
      <div class="position-relative border border-5 border-white opacity-100 h-100 vr">
         <div class="d-flex justify-content-center">
            <div class="bg-orange-500 rounded-circle p-2 position-absolute fs-4 text-black" style="height: 50px; width:50px; margin-top:-6px;">
               <i class="fa-solid fa-bed"></i>
            </div>
         </div>
      </div>
   </div> <!-- Barra Lateral -->
   <div class="col-10 mb-5">
      <div class="row mb-3">
         <h3 class="fw-bold">Hospedaje</h3>
      </div>
      <div class="row">
         <h4>
            <p></p><a class="text-reset" href="#">Enlace al Hospedaje</a></p>
            Ciudad: Zurich<br />
            Nombre Hospedaje: Hotel Altstadt<br />
            Ingreso: 2025-10-02 Salida: 2025-10-03
         </h4>
      </div>
   </div> <!-- Información del Tour -->
</div>
<div class="row">
   <div class="col-2 text-center">
      <div class="position-relative border border-5 border-white opacity-100 h-100 vr">
         <div class="d-flex justify-content-center">
            <div class="bg-orange-500 rounded-circle p-2 position-absolute fs-4 text-black" style="height: 50px; width:50px; margin-top:-6px;">
               <a class="text-reset" href="#"><i class="fw-bold fa-solid fa-circle-down"></i></a>
            </div>
         </div>
      </div>
   </div> <!-- Barra Lateral -->
</div>