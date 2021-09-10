<?php declare(strict_types = 1);

class ControllerAuthorisation extends Controller
{
   public function __construct()
   {
      if (!isAdmin())
      {
         $this->view->render('/error/restricted');
         exit();
      }
      parent::__construct();
   }
}