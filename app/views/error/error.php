<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php');
   ?>

</head>
<body class="d-flex flex-column min-vh-100">
   <main>
      <?php
         require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'navigator.php');
      ?>
      <div class="container text-center alert rk" role="alert">
         <h1 class="h1-responsive text-center text-danger">
            <?php echo $data[0];?>
         </h1>
         <?php echo $data[1];?>         
      </div>

   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php');
   ?>
   </main>
   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'scripts.php');
   ?>
</body>
</html>