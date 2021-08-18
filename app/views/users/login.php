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
      <form class="from-inline" method="POST" action="/users/login">
         <img class="mb-4" src="/img/logo2.png" width="150">
         <h1 class="h2 mb-3 fw-normal">Sign in</h1>
         <label for="email">Email address</label>
         <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
         <label for="password">Password</label>
         <input type="password" class="form-control" id="password" name="password" placeholder="Password">
         <?php if (isset($data['loginError']) && !empty($data['loginError'])) : ?>
            <div class="alert alert-warning mx-auto">
               <?php echo $data['loginError'] ?>
            </div>
         <?php endif; ?>
         <!-- TODO: not great not terrible solution -->
         <br/>
         <button class="btn btn-lg btn-info" type="submit" id="submit" value="submit">Sign in</button>
      </form>
      <div class="container w-100">
         <h1 class="h5 mt-5 fw-normal">Not registered?</h1>
         <a href="/users/register"><button class="btn btn-lg btn-outline-info mb-5">Register</button></a>
      </div>
      <div class="alert alert-primary text-left" role="alert">
         <h1 class="h3 mt-2 fw-normal text-center">Temporary login data</h1>
         <span class="badge badge-primary">Administrator</span> <span class="text-primary">t@nebes.hr</span> <span class="text-secondary">letmeinside1</span>
         <br />
         <span class="badge badge-info">User</span> <span class="text-primary">normal@person.com</span> <span class="text-secondary">letmeinside1</span>
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