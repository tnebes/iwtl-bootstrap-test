<?php declare(strict_types = 1);

   Class ControllerPages extends Controller
   {
      public function __construct()
      {
         parent::__construct();
      }

      public function index() : void
      {
         $this->view->render->render('pages/index');
      }

      public function about() : void
      {
         header('location: https://www.github.com/tnebes');
      }

   }