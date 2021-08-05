<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php');
   ?>

</head>
<body class="d-flex flex-column">
   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'navigator.php');
   ?>

   <!-- add diagram img here -->
   <div class="d-flex flex-column">
      <div class="p-2">
         <img src="<?php new Image('er' . DIRECTORY_SEPARATOR . 'iwtl_diagram.png')?>" alt="ER Diagram" class="img-fluid mx-auto d-block" style="max-width: 100%;">
      </div>
      <div class="p-2 mx-auto my-5 bg-light">
         <h1 class="h1 text-dark px-5 mt-4">SQL code</h1>
         <?php
            $file = fopen(APP_ROOT . '/content/er/i_want_to_learn.sql', 'r');
            // read and echo file line by line
            echo '<pre class="my-5 mx-5">';
            $counter = 0;
            while(!feof($file)) 
            {
               $line = fgets($file);
               echo '<code>';
               echo sprintf('%3d| ', $counter++);
               echo $line;
               echo '</code>';
               echo '<br/>';
            }
            echo '</pre>';
         ?>
      </div>
   </div>



   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php');
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'scripts.php');
   ?>
</body>
</html>