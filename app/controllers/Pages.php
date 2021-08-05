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

      // TODO: implement this
      public function about() : void
      {
         $this->view('error/error/404');
      }

   }