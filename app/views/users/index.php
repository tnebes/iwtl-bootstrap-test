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
   <main>
      <div class="table-responsive">
         <?php if(isAdmin()): ?>
         <?php $users = $data['users']; ?>
         <table class="table table-hover">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Date Registered</th>
                  <th>Last Login</th>
                  <th>Banned</th>
                  <th>Date Banned</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  foreach ($users as $user) 
                  {
                     echo '<tr>';
                     echo '<td>' . $user->id . '</td>';
                     echo '<td>' . $user->username . '</td>';
                     echo '<td>' . $user->email . '</td>';
                     echo '<td>' . $user->role . '</td>';
                     echo '<td>' . $user->registrationDate . '</td>';
                     echo '<td>' . $user->lastLogin . '</td>';
                     echo '<td>' . $user->banned . '</td>';
                     echo '<td>' . $user->dateBanned . '</td>';
                     echo '<td>' . 'meh' . '</td>';
                     echo '</tr>';
                  }
               ?>
            </tbody>
         </table>
         <?php else: ?>
            <?php $users = $data['users']; ?>
            <table class="table table-hover">
            <thead>
               <tr>
                  <th>Username</th>
                  <th>Date Registered</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  foreach ($users as $user) 
                  {
                     echo '<tr>';
                     echo '<td>' . $user->username . '</td>';
                     echo '<td>' . $user->registrationDate . '</td>';
                     echo '</tr>';
                  }
               ?>
            </tbody>
         </table>

         <?php endif;?>
      </div>
      <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php');
      ?>
   </main>
   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'scripts.php');
   ?>
   
</html>