<?php declare(strict_types =1);

   class ControllerErrorPages extends Controller
   {
      public function __construct()
      {
         parent::__construct();
      }

      // TODO: implement data for these pages instead of using three different pages!
      public function notFound() : void
      {
         $this->view->render('error' . DIRECTORY_SEPARATOR .'error', ['Page not found.', "The page you're looking for doesn't exist."]);
      }

      public function restricted() : void
      {
         $this->view('error' . DIRECTORY_SEPARATOR .'error', ['You are not allowed to do this.', "You don't have the permission to do this."]);
      }

      public function notImplemented() : void
      {
         $this->view('error' . DIRECTORY_SEPARATOR .'error', ['Work in progress. Check back later.', "This feature is not implemented yet."]);
      }

      public function internalError() : void
      {
         $this->view('error' . DIRECTORY_SEPARATOR .'error', ['Internal server error.', "Something went wrong on our side."]);
      }
   }
