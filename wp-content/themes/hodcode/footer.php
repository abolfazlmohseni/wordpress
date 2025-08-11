 <?php wp_footer(); ?>

 <footer class="flex items-center justify-between max-w-screen-lg mx-auto border-t border-t-gray-300 mt-20 py-5">
     <div class="w-12 h-12 ml-2">
         <?php if (function_exists("the_custom_logo")) {
                the_custom_logo();
            } ?>
     </div>
     <div>
         <p class="text-gray-900">C كليه حقوق اين سايت براى پارت محفوظ میباشد.</p>
     </div>
     <div>
         <?php wp_nav_menu([
                "theme_location" => "footer",
                "menu_class" => "flex gap-4 text-gray-800 ",
                "container" => false
            ]) ?>
     </div>
 </footer>










 </body>

 </html>