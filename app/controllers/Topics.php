<?php declare(strict_types = 1);

   class Topics extends Controller
   {
      public function __construct()
      {
         
      }

      public function index() : void
      {
         $this->view('topics/index');
      }
   }