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
            $this->view('error/error/403');
            return;
         }
         
         $this->view('er/index');
      }
   }