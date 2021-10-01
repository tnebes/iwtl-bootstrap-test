<?php

declare(strict_types=1);

class ControllerEr extends Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index(): void
   {
      if (!Helper::getInstance()->isLoggedIn()) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }

      $this->view->render('er/index');
   }
}
