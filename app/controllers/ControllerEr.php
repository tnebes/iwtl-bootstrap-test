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
         (new ControllerErrorPages())->restricted();
         return;
      }

      $this->view->render('er/index');
   }
}
