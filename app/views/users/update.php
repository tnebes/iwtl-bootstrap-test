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

      <?php if (isAdmin()) : ?>
         <?php // TODO: this is bad.
         $user = $data[0];
         $data = $data[1];
         ?>
         <div class="card bg-dark">
            <div class="card-header">
               <h2 class="alert alert-primary">
                  <?php
                  echo 'Edit ' . $user->username ?>'s Profile
               </h2>
               <?php
               echo '<a class="btn btn-danger" href=' . URL_ROOT . '/users/delete/' . $user->id . '>Delete User</a>';
               echo '<a class="btn btn-warning" href=' . URL_ROOT . '/users/ban/' . $user->id . '>Ban User</a>';
               ?>
            </div>
            <form class="card-body" method="POST" action="<?php echo URL_ROOT . '/users/update/' . $user->id; ?>">
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-primary text-dark">Username</label>
                     <p><?php echo $user->username ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Username</label>
                     <span class="text-danger"><?php echo $data['usernameError'] ?></span>
                     <input type="text" name="username" class="form-control" value="<?php echo $user->username ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-primary text-dark">Email</label>
                     <p><?php echo $user->email ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Email</label>
                     <span class="text-danger"><?php echo $data['emailError'] ?></span>
                     <input type="email" name="email" class="form-control" value="<?php echo $user->email ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Password</label>
                     <span class="text-danger"><?php echo $data['passwordError'] ?></span>
                     <input type="password" name="password" class="form-control" value="">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-primary text-dark">Registration Date</label>
                     <p><?php echo $user->registrationDate ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Registration Date</label>
                     <span class="text-danger"><?php echo $data['registrationDateError'] ?></span>
                     <input type="date" name="registrationDate" class="form-control" value="<?php echo date("Y-m-d", strtotime($user->registrationDate));?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-primary text-dark">Role</label>
                     <p><?php echo roleToString($user->role)?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Role</label>
                     <span class="text-danger"><?php echo $data['roleError'] ?></span>
                     <select name="role" class="form-control">
                        <option selected value="<?php echo $user->role?>"><?php echo roleToString($user->role)?></option>
                        <option value="0">User</option>
                        <option value="1">Admin</option>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-primary text-dark">Last Login</label>
                     <p><?php echo $user->lastLogin ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Last Login</label>
                     <span class="text-danger"><?php echo $data['lastLoginError'] ?></span>
                     <input type="date" name="lastLogin" class="form-control" value="<?php echo date("Y-m-d", strtotime($user->lastLogin))?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">Banned</label>
                     <p>
                        <?php echo bannedToCheckbox($user->banned) ?>
                     </p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="badge bg-primary text-dark">Date Banned</label>
                     <p><?php echo $user->dateBanned ?></p>
                  </div>
                  <div class="col-md-6">
                     <label class="badge bg-info text-dark">New Date Banned</label>
                     <span class="text-danger"><?php echo $data['dateBannedError'] ?></span>
                     <input type="date" name="dateBanned" class="form-control" value="<?php echo date("Y-m-d", strtotime($user->dateBanned)); ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <input type="submit" class="btn btn-success" value="Update User">
                  </div>
               </div>
            </form>
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