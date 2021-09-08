<?php declare(strict_types = 1);

   class Controller
   {
      protected $view;

      public function getModel(string $model)
      {
         if (file_exists(APP_ROOT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model . '.php'))
         {
            require_once APP_ROOT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model . '.php';
            return new $model();
         }
         die('Model not found.');
      }

      public function __construct()
      {
         $this->view = new View();
      }

      public function view(string $view, array $data = []) : void
      {
         $this->view = new View();
      }
   }
   