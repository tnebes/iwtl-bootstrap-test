<?php

declare(strict_types=1);

class ControllerEr extends Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   /**
    * The index page where the ER diagram is shown.
    */
   public function index(): void
   {
      if (!Helper::getInstance()->isLoggedIn()) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }

      $this->view->render('er/index');
   }
}
