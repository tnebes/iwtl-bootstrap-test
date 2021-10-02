<?php declare(strict_types = 1);

class ControllerSuggestions extends Controller 
{
   public function __construct()
   {
      parent::__construct();
      $this->model = $this->getModel('User');
      $helper = Helper::getInstance();
   }
   
   public function index()
   {
      header('location:' . URL_ROOT . '/errorPages/notFound');
   }
}

