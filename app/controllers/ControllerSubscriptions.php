<?php declare(strict_types = 1);

class ControllerSubscriptions extends Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->model = $this->getModel('UserTopicSubscription');
      $helper = Helper::getInstance();
   }

   public function index() : void
   {
      echo 'hello!';
   }
}