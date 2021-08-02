<?php declare(strict_types = 1);

   class Controller
   {
      public function model(string $model)
      {
         require_once '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model . '.php';
         return new $model();
      }

      public function view(string $view, array $data = []) : void
      {
         if (file_exists('..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php'))
         {
            require_once '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
         }
         else
         {
            // TODO: check this
            require_once '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'error' . DIRECTORY_SEPARATOR . 'notFound.php';
         }
      }
   }