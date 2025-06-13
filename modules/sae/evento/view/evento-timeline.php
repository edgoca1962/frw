<style>
   .main-timeline {
      position: relative;
   }

   .main-timeline::after {
      content: '';
      position: absolute;
      width: 6px;
      background-color: #939597;
      top: 0;
      bottom: 0;
      left: 50%;
      margin-left: -3px;
   }

   .timeline {
      position: relative;
      background-color: inherit;
      width: 50%;
   }

   .timeline::after {
      content: '';
      position: absolute;
      width: 25px;
      height: 25px;
      right: -13px;
      background-color: #939597;
      border: 5px solid #f5df4d;
      top: 15px;
      border-radius: 50%;
      z-index: 1;
   }

   .left {
      padding: 0px 40px 20px 0px;
      left: 0;
   }

   .right {
      padding: 0px 0px 20px 40px;
      left: 50%;
   }

   .left::before {
      content: " ";
      position: absolute;
      top: 18px;
      z-index: 1;
      right: 30px;
      border: medium solid white;
      border-width: 10px 0 10px 10px;
      border-color: transparent transparent transparent white;
   }

   .right::before {
      content: " ";
      position: absolute;
      top: 18px;
      z-index: 1;
      left: 30px;
      border: medium solid white;
      border-width: 10px 10px 10px 0;
      border-color: transparent white transparent transparent;
   }

   .right::after {
      left: -12px;
   }

   .card {
      padding: 0px 30px;
      position: relative;
      border-radius: 6px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
   }

   @media screen and (max-width: 600px) {
      .main-timeline::after {
         left: 31px;
      }

      .timeline {
         width: 100%;
         padding-left: 70px;
         padding-right: 25px;
      }

      .timeline::before {
         left: 60px;
         border: medium solid white;
         border-width: 10px 10px 10px 0;
         border-color: transparent white transparent transparent;
      }

      .left::after,
      .right::after {
         left: 18px;
      }

      .left::before {
         right: auto;
      }

      .right {
         left: 0%;
      }
   }
</style>
<div class="container py-5">
   <h2 class="text-center mb-5">Company Timeline</h2>

   <div class="main-timeline">
      <div class="timeline left">
         <div class="card">
            <div class="card-body p-4">
               <h3>2023</h3>
               <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, et elementum lorem ornare.</p>
            </div>
         </div>
      </div>
      <div class="timeline right">
         <div class="card">
            <div class="card-body p-4">
               <h3>2022</h3>
               <p class="mb-0">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
         </div>
      </div>
      <div class="timeline left">
         <div class="card">
            <div class="card-body p-4">
               <h3>2021</h3>
               <p class="mb-0">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
            </div>
         </div>
      </div>
      <div class="timeline right">
         <div class="card">
            <div class="card-body p-4">
               <h3>2020</h3>
               <p class="mb-0">Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.</p>
            </div>
         </div>
      </div>
   </div>
</div>