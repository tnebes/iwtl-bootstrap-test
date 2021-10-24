<?php

declare(strict_types=1);

require_once '../app/controllers/ControllerAuthorisation.php';

class ControllerControlpanel extends ControllerAuthorisation
{
   public function index(): void
   {
      echo 'test';
   }
}
