<?php

declare(strict_types=1);

class Controller
{
   protected $view;
   protected $helper;

   public function getModel(string $model): Model
   {
      try {
         $returnModel = new $model();
         if ($returnModel instanceof Model) {
            return $returnModel;
         }
      } catch (Exception $e) {
         //TODO: could be handled better.
         die($model . ' model not found.');
      }
      return $returnModel;
   }

   protected function redirectIfNotLoggedIn(): bool
   {
      if (!Helper::getInstance()->isLoggedIn()) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return true;
      }
      return false;
   }

   public function __construct()
   {
      $this->view = new View();
      $this->helper = Helper::getInstance();
   }

   public function view(string $view, array $data = []): void
   {
      $this->view = new View();
   }
}
