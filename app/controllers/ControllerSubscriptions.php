<?php declare(strict_types = 1);

class ControllerSubscriptions extends Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->model = $this->getModel('UserTopicSubscription');
   }

   public function index() : void
   {
      if (!$this->helper->isLoggedIn())
      {
         header('location: ' . URL_ROOT . 'errorPages/restricted');
         return;
      }
      $data = ['subscriptions' => $this->model->getSubscriptionsFromUser((int) $_SESSION['id'])];
      $this->view->render('/subscriptions/index', $data);
   }
}