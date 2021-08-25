<?php declare(strict_types = 1);

   class Controller
   {
      public function getModel(string $model)
      {
         if (file_exists(APP_ROOT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model . '.php'))
         {
            require_once APP_ROOT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model . '.php';
            return new $model();
         }
         die('Model not found.');
      }

      public function view(string $view, array $data = []) : void
      {
         if (file_exists(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php'))
         {
            require_once APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
         }
         else if(file_exists(APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'error' . DIRECTORY_SEPARATOR . 'error.php'))
         {
            // TODO: check this
            require_once APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'error' . DIRECTORY_SEPARATOR . 'error.php';
         }
         else
         {
            die('Fatal error. Please contact the administrator.');
         }
      }
   }