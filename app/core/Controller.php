<?php declare(strict_types = 1);

   class Controller
   {
      protected $view;

      public function getModel(string $model) : Model
      {
         // if (file_exists(APP_ROOT . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model . '.php'))
         // {
         //    require_once APP_ROOT . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model . '.php';
         //    return new $model();
         // }
         // die('Model not found.');
         try
         {
            $returnModel = new $model();
            if ($returnModel instanceof Model)
            {
               return $returnModel;
            }
         }
         catch (Exception $e)
         {
            //TODO: could be handled better.
            die($model . ' model not found.');
         }
         return $returnModel;
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
   