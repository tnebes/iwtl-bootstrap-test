<?php declare(strict_types = 1);

   Class Pages extends Controller
   {
      public function __construct()
      {
         // TODO:
      }

      public function index() : void
      {
         $this->view('pages/index');
      }

      public function about() : void
      {
         header('location: https://www.github.com/tnebes');
      }

   }