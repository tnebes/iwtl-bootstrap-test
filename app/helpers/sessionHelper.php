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
         new User();
      }
      return false;
   }

   function createUserSession(stdClass $user) : void
   {
      $_SESSION['id'] = $user->id;
      $_SESSION['username'] = $user->username;
   }