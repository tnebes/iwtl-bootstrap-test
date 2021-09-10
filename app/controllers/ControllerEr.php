<?php declare(strict_types = 1);

   Class ControllerEr extends Controller
   {
      public function __construct()
      {
         parent::__construct();  
      }

      public function index() : void
      {
         if (!isLoggedIn())
         {
            header('location: errorpages/restricted');
            return;
         }
         
         $this->view->render('er/index');
      }
   }