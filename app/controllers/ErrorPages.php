<?php declare(strict_types =1);

   class ErrorPages extends Controller
   {
      public function __construct()
      {
         // TODO:
      }

      public function notFound() : void
      {
         $this->view('error/notFound');
      }

      public function restricted() : void
      {
         $this->view('error/restricted');
      }
   }

?>