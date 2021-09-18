<?php

declare(strict_types=1);

class Controller
{
   protected $view;

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
         (new ControllerErrorPages())->restricted();
         return true;
      }
      return false;
   }

   public function __construct()
   {
      $this->view = new View();
   }

   public function view(string $view, array $data = []): void
   {
      $this->view = new View();
   }
}
