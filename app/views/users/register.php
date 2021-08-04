<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php');
   ?>
   <link rel="stylesheet" type="text/css" href="login-register.css">

</head>
<body class="text-center">
   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'navigator.php');
   ?>
   <main class="form-signin">
      <div class="container w-25 h-75">
         <form class="from-inline" method="POST" action="/users/register">
            <img class="mb-4" src="/img/logo2.png" width="150">
            <h1 class="h2 mb-3 fw-normal">Register</h1>
            <div class="form-floating">
               <input type="text" class="form-control" id="username" name="username" placeholder="username">
               <?php if(!empty($data['usernameError'])): ?>
                  <span class="alert rk"><?php echo $data['usernameError'] ?></span>
                  </br>
               <?php endif; ?>
               <label for="username">Username</label>
            </div>
            <div class="form-floating">
               <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
               <?php if(!empty($data['emailError'])): ?>
                  <span class="alert rk"><?php echo $data['usernameError'] ?></span>
                  </br>
               <?php endif; ?>
               <label for="email">Email address</label>
            </div>
            <div class="form-floating">
               <input type="password" class="form-control" id="password" name="password" placeholder="Password">
               <?php if(!empty($data['passwordError'])): ?>
                  <span class="alert rk"><?php echo $data['usernameError'] ?></span>
                  </br>
               <?php endif; ?>
               <label for="password">Password</label>
            </div>
            <div class="form-floating">
               <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
               <?php if(!empty($data['confirmPasswordError'])): ?>
                  <span class="alert rk"><?php echo $data['usernameError'] ?></span>
                  </br>
               <?php endif; ?>
               <label for="password">Confirm Password</label>
            </div>
            <button class="w-75 btn btn-lg btn-info mb-5" type="submit" id="submit" value="submit">Register</button>
         </form>
      </div>
   </main>
   <?php
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php');
      require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'scripts.php');
   ?>
</body>
</html>