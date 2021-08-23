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
         $this->view('error/error/', ['Page not found.', "The page you're looking for doesn't exist."]);
      }

      public function restricted() : void
      {
         $this->view('error/error/', ['You are not allowed to do this.', "You don't have the permission to do this."]);
      }

      public function notImplemented() : void
      {
         $this->view('error/error/', ['Work in progress. Check back later.', "This feature is not implemented yet."]);
      }
   }
