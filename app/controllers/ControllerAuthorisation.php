<?php

declare(strict_types=1);

class ControllerAuthorisation extends Controller
{
   public function __construct()
   {
      parent::__construct();
      if (!Helper::getInstance()->isAdmin()) {
         $this->view->render('/error/restricted');
         exit();
      }
   }
}
