<?php declare(strict_types = 1);

class ControllerSubscriptions extends Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->model = $this->getModel('UserTopicSubscription');
   }

    /**
     * method returns the data required for the index page of subscriptions to have content.
     */
    public function index() : void
   {
      if (!$this->helper->isLoggedIn())
      {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }
      $data = ['subscriptions' => $this->model->getSubscriptionsFromUser((int) $_SESSION['id'])];
      $this->view->render('/subscriptions/index', $data);
   }

    /**
     * Method handles the subscription or unsubscription of a user to a topic
     */
    public function subscribe() : void
   {
      if (!$this->helper->isLoggedIn())
      {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }
      $topicId = (int) func_get_arg(0);
      $data = [
         'redirect' => $_SERVER['HTTP_REFERER'] ?? URL_ROOT . 'subscriptions',
      ];
      // check if the user is already subscribed
      if ($this->model->userIsSubscribedToTopic((int) $_SESSION['id'], $topicId))
      {
         $this->model->unsubscribe((int) $_SESSION['id'], $topicId);
         $data['message'] = 'You have unsubscribed from this topic.';
      }
      else
      {
         $this->model->subscribe((int) $_SESSION['id'], $topicId);
         $data['message'] = 'You have subscribed to this topic.';
      }
      $this->view->render('/subscriptions/message', $data);
   }

}