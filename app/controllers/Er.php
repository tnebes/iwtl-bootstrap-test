<?php declare(strict_types = 1);

   Class Er extends Controller
   {
      public function __controller()
      {

      }

      public function index() : void
      {
         if (!isLoggedIn())
         {
            header('location: errorpages/restricted');
            return;
         }
         
         $this->view('er/index');
      }
   }