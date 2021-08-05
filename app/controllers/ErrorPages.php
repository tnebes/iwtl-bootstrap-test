<?php declare(strict_types =1);

   class ErrorPages extends Controller
   {
      public function __construct()
      {
         // TODO:
      }

      // TODO: implement data for these pages instead of using three different pages!
      public function notFound() : void
      {
         $this->view('error/error/404');
      }

      public function restricted() : void
      {
         $this->view('error/error/404');
      }

      public function notImplemented() : void
      {
         $this->view('error/error/404');
      }
   }
