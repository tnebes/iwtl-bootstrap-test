<?php declare(strict_types = 1);

   session_start();

   function isLoggedIn() : bool
   {
      return isset($_SESSION['id']);
   }

   function isAdmin() : bool
   {
      if (isLoggedIn())
      {
         $userModel = new User();
         return $userModel->getIsAdmin($_SESSION['id']);
      }
      return false;
   }

   function createUserSession(stdClass $user) : void
   {
      $_SESSION['id'] = $user->id;
      $_SESSION['username'] = $user->username;
   }

   function clearUserSession() : void
   {
      unset($_SESSION['id']);
      unset($_SESSION['username']);
   }