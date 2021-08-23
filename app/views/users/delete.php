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
         $user = $data[0]; // TODO: fix me.
      ?>

      <div class="p-4 bg-dark">
         <div class="card bg-dark">
            <div class="card-body">
               <h4 class="card-title">Delete User</h4>
               <p class="card-text">
                  <form action="<?php echo URL_ROOT . '/users/delete/' . $user->id; ?>" method="POST">
                     <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                     <p>Are you sure you want to delete <?php echo $user->username; ?>? This action cannot be undone.</p>
                     <button type="submit" name="confirm" value="true" class="btn btn-danger">Delete User</button>
                     <button type="submit" name="confirm" value="false" class="btn btn-success">Cancel</button>
                  </form>
               </p>
            </div>
         </div>
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