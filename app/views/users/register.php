<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
   <?php
   require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php');
   ?>
   <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT . '/public/css/login-register.css' ?>">

</head>

<body class="text-center h-100">
   <?php
   require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'navigator.php');
   ?>
   <main class="form-signin">
      <form class="from-inline" method="POST" action="/users/register">
         <img class="mb-4" src="/img/logo2.png" width="150">
         <h1 class="h2 mb-3 fw-normal">Register</h1>
         <label for="username">Username</label>
         <?php if (!empty($data['usernameError'])) : ?>
            <span class="text-warning" role="alert"><?php echo $data['usernameError'] ?></span>
         <?php endif; ?>
         <input type="text" class="form-control" id="username" name="username" placeholder="username">
         <div class="form-floating">
            <label for="email">Email address</label>
            <?php if (!empty($data['emailError'])) : ?>
               <span class="text-warning"><?php echo $data['usernameError'] ?></span>
            <?php endif; ?>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
         </div>
         <div class="form-floating">
         <label for="password">Password</label>
            <?php if (!empty($data['passwordError'])) : ?>
               <span class="text-warning"><?php echo $data['usernameError'] ?></span>
            <?php endif; ?>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
         </div>
         <div class="form-floating">
            <label for="password">Confirm Password</label>
            <?php if (!empty($data['confirmPasswordError'])) : ?>
               <span class="text-warning"><?php echo $data['usernameError'] ?></span>
            <?php endif; ?>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
         </div>
         <button class="w-75 btn btn-lg btn-info mb-5" type="submit" id="submit" value="submit">Register</button>
      </form>
      <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php');
      ?>
   </main>
   <?php
   require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'scripts.php');
   ?>
</body>

</html>