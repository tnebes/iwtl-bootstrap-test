<?php declare(strict_types = 1);

class Authorisation extends Controller
{
   public function __construct()
   {
      if (!isAdmin())
      {
         $this->view('/error/restricted');
         exit();
      }
   }
}