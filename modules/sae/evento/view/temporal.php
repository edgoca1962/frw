<?php

use WPFRW\Modules\Core\Core;

$core = Core::get_instance();

$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = 'http://localhost:3000/evento/?cpt=evento&recurrencia=3&mes=February&anno=2025';
echo $url . '<br />';
$url = explode('?', $url);
// print_r($url);
// echo '<br />';
echo 'Parámetros: ' . end($url) . '<br>';


/******************************************************************************
 * Convertir text en mayúsculas
 *****************************************************************************/
$dato = 'mayúscula en la primera letra';
$dato = ucwords($dato);
echo $dato . '<br>';
/******************************************************************************
 * Para incluir horario diferenciado
 *****************************************************************************/
$dato = ['2025-02-17', '2025-02-18'];
// update_post_meta(1905, '_f_excluidas', $dato);

$h_n1 =   [
   '2025-02-22' =>
   [
      'h_inicial' => '09:00',
      'h_final' => '16:00'
   ]
];
$h_n2 =   [
   '2025-02-23' =>
   [
      'h_inicial' => '09:00',
      'h_final' => '16:00'
   ]
];
$dato = [json_encode($h_n1), json_encode($h_n2)];
// update_post_meta(1896, '_horario_diferenciado', $dato);
$dato = [1, 2, 3, 4, 5];
// update_post_meta(1896,"_diasemanaevento",$dato);

$dato = '{"2025-02-22":{"h_inicial":"09:00","h_final":"16:00"}},{"2025-02-23":{"h_inicial":"09:00","h_final":"16:00"}}';
$dato = str_replace("},{", "};{", $dato);
$dato = explode(";", $dato);
// update_post_meta(1889, '_horario_diferenciado', $dato);


$dato = 'eventocolaborador';
$dato = strpos($dato, 'colaborador');
echo 'dato ' . $dato;

/******************************************************************************
 * Lógica para determinar las fechas de un evento en evento.php
 *****************************************************************************/
/*
if (isset($_GET['fpe'])) {
   $fpe_param = sanitize_text_field($_GET['fpe']);
   $mesEvento = date('F', strtotime($fpe_param));
   $annoEvento = date('Y', strtotime($fpe_param));
} else {
   $fpe_param = 0;
   $mesEvento = isset($_GET['mes']) ? sanitize_text_field($_GET['mes']) : date('F');
   $annoEvento = isset($_GET['anno']) ? sanitize_text_field($_GET['anno']) : date('Y');
}
if (get_post_meta(get_the_ID(), '_diasemanaevento', true) == null) {
   $diasemanaevento = [];
} else {
   $diasemanaevento = get_post_meta(get_the_ID(), '_diasemanaevento', true);
}

$fechasevento = $evento->sae_fechasevento(
   get_the_ID(),
   $fpe_param,
   date('Y-m-d H:i:s', strtotime(get_post_meta(get_the_ID(), '_f_inicio', true))),
   get_post_meta(get_the_ID(), '_f_final', true),
   get_post_meta(get_the_ID(), '_h_final', true),
   get_post_meta(get_the_ID(), '_periodicidadevento', true),
   get_post_meta(get_the_ID(), '_npereventos', true),
   get_post_meta(get_the_ID(), '_opcionesquema', true),
   get_post_meta(get_the_ID(), '_numerodiaordinalevento', true),
   $diasemanaevento,
   get_post_meta(get_the_ID(), '_mesevento', true),
   $mesEvento,
   $annoEvento
);
print_r($fechasevento)     
*/
?>
/******************************************************************************
* Tarjetas con reverso y animación para cada una ORIGINAL.
*****************************************************************************/
<style>
   .service-card {
      perspective: 1000px;
      width: 18rem;
      height: 400px;
   }

   .service-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.8s;
      transform-style: preserve-3d;
      cursor: pointer;
   }

   .service-card:hover .service-card-inner {
      transform: rotateY(180deg);
   }

   .service-card-front,
   .service-card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      overflow: hidden;
   }

   .service-card-front-old {
      background: linear-gradient(45deg, #6366f1, #8b5cf6);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 2rem;
   }

   .service-card-back {
      background: white;
      color: #1f2937;
      transform: rotateY(180deg);
      padding: 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
   }

   .icon-wrapper {
      width: 80px;
      height: 80px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
   }

   .feature-list {
      list-style: none;
      padding: 0;
      margin: 0;
   }

   .feature-list li {
      padding: 0.5rem 0;
      border-bottom: 1px solid #e5e7eb;
   }

   .feature-list li:last-child {
      border-bottom: none;
   }

   .hover-lift {
      transition: transform 0.2s;
   }

   .hover-lift:hover {
      transform: translateY(-5px);
   }
</style>
<div class="container py-5">
   <div class="row row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
      <!-- Service Card 1 -->
      <div class="col">
         <div class="service-card hover-lift">
            <div class="service-card-inner  rounded-3" style="background: url(<?php echo get_template_directory_uri() . '/assets/img/sae/privilegiados.jpeg' ?>) no-repeat center /cover;">
               <div class="service-card-front">
               </div>
               <div class="service-card-back">
                  <h4 class="mb-3">Our Expertise</h4>
                  <ul class="feature-list">
                     <li>Custom Website Development</li>
                     <li>Responsive Design</li>
                     <li>Performance Optimization</li>
                     <li>SEO Integration</li>
                  </ul>
                  <button class="btn btn-primary mt-4">Learn More</button>
               </div>
            </div>
         </div>
      </div>

      <!-- Service Card 2 -->
      <div class="col">
         <div class="service-card hover-lift">
            <div class="service-card-inner">
               <div class="service-card-front" style="background: url(<?php echo get_template_directory_uri() . '/assets/img/sae/elamorqueperdura.jpeg' ?>) no-repeat center /cover;">
               </div>
               <div class="service-card-back">
                  <h4 class="mb-3">Design Services</h4>
                  <ul class="feature-list">
                     <li>User Interface Design</li>
                     <li>User Experience Research</li>
                     <li>Prototyping</li>
                     <li>Design Systems</li>
                  </ul>
                  <button class="btn btn-primary mt-4">Learn More</button>
               </div>
            </div>
         </div>
      </div>

      <!-- Service Card 3 -->
      <div class="col">
         <div class="service-card hover-lift">
            <div class="service-card-inner">
               <div class="service-card-front" style="background: url(<?php echo get_template_directory_uri() . '/assets/img/sae/presentacionbebes.jpeg' ?>) no-repeat center /cover;">
               </div>
               <div class="service-card-back">
                  <h4 class="mb-3">Marketing Solutions</h4>
                  <ul class="feature-list">
                     <li>SEO Optimization</li>
                     <li>Content Strategy</li>
                     <li>Social Media Marketing</li>
                     <li>Analytics & Reporting</li>
                  </ul>
                  <button class="btn btn-primary mt-4">Learn More</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
/******************************************************************************
* Tarjetas con reverso y animación para cada una MODIFICADA
*****************************************************************************/
<style>
   .card {
      perspective: 1000px;
   }

   .service-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.8s;
      transform-style: preserve-3d;
      cursor: pointer;
   }

   .card:hover .service-card-inner {
      transform: rotateY(180deg);
   }

   .service-card-front,
   .service-card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      border-radius: 15px;
      overflow: hidden;
   }


   .service-card-back {
      transform: rotateY(180deg);
   }

   .hover-lift {
      transition: transform 0.2s;
   }

   .hover-lift:hover {
      transform: translateY(-5px);
   }
</style>
<div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-4 py-5">
   <?php for ($i = 0; $i < 9; $i++): ?>
      <div class="col">
         <div class="card border-0 rounded-4 mx-auto" style="width: 18rem; height: 25rem;">
            <div class="service-card-inner">
               <div class="service-card-front shadow" style="background: url(<?php echo get_template_directory_uri() . '/assets/img/sae/elamorqueperdura.jpeg' ?>) no-repeat center /cover;">
               </div>
               <div class="service-card-back shadow bg-primary p-3">
                  <h4 class="mb-3">Marketing Solutions</h4>
               </div>
            </div>
         </div>
      </div>
   <?php endfor; ?>
</div>
/******************************************************************************
* Caurosel con 3 itmes para cada
*****************************************************************************/
<style>
   .carousel-control-prev,
   .carousel-control-next {
      width: 40px;
      height: 40px;
      background-color: #6366f1;
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
   }

   .carousel-control-prev {
      left: -20px;
   }

   .carousel-control-next {
      right: -20px;
   }
</style>
<div class="container py-5">
   <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
         <?php
         $counter = 0;
         foreach ($datos as $tipo => $valor) :
            // Inicia un nuevo grupo de 3 tarjetas
            if ($counter % 3 == 0) {
               // Agrega la clase 'active' solo al primer grupo
               echo '<div class="p-3 carousel-item ' . ($counter == 0 ? 'active' : '') . '"><div class="row row-cols-auto">';
            }
         ?>
            <div class="col">
               <div class="card p-3 border-1" style="width: 17rem; height: 25rem;">
                  <h3>Tarjeta <?php echo $tipo ?></h3>
               </div>
            </div>
         <?php
            $counter++;
            // Cierra el grupo de 3 tarjetas
            if ($counter % 3 == 0 || $counter == count($datos)) {
               echo '</div></div>';
            }
         endforeach;
         ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Next</span>
      </button>
   </div>
</div>