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
      $data = $data[0];
      ?>

      <?php if (isAdmin()) : ?>
         <div class="card bg-dark">
            <div class="card-header">
               <h2 class="alert alert-primary">
                  <?php
                  echo $data->username ?>'s Profile
               </h2>
               <?php
               echo '<a class="button warning" href=' . URL_ROOT . '/users/delete/' . $data->id . '>Delete User</a>';
               echo '<a class="button alert" href=' . URL_ROOT . '/users/ban/' . $data->id . '>Ban User</a>';
               ?>
            </div>
            <form class="card-body" method="POST" action="<?php echo URL_ROOT . '/users/update/' . $data->id; ?>">
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Username</label>
                     <p><?php echo $data->username ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Username</label>
                     <input type="text" name="username" class="form-control" value="<?php echo $data->username ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Email</label>
                     <p><?php echo $data->email ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Email</label>
                     <input type="text" name="email" class="form-control" value="<?php echo $data->email ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Registration Date</label>
                     <p><?php echo $data->registrationDate ?></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Role</label>
                     <p><?php echo $data->role ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Role</label>
                     <select name="role" class="form-control">
                        <option value="0">User</option>
                        <option value="1">Admin</option>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Last Login</label>
                     <p><?php echo $data->lastLogin ?></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Banned</label>
                     <p><?php echo $data->banned ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Banned</label>
                     <br/>
                     <input class="left" type="checkbox" name="banned" class="form-control" value="1" <?php echo $data->banned ? 'checked' : '' ?>>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Date Banned</label>
                     <p><?php echo $data->dateBanned ?></p>
                  </div>
               </div>
            </form>
         </div>
      <?php else : ?>
         <div class="card bg-dark">
            <div class="card-header">
               <h2 class="alert alert-primary">
                  <?php
                  echo $data->username ?>'s Profile
               </h2>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Username</label>
                     <p><?php echo $data->username ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Registration Date</label>
                     <p><?php echo $data->registrationDate ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Role</label>
                     <p><?php echo $data->role ?></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Banned</label>
                     <p><?php echo $data->banned ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Date Banned</label>
                     <p><?php echo $data->dateBanned ?></p>
                  </div>
               </div>
            </div>
         </div>
      <?php endif; ?>

      <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php');
      ?>
   </main>
   <?php
   require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'scripts.php');
   ?>
</body>

</html>