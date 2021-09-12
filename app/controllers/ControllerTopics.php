<?php declare(strict_types = 1);

   class ControllerTopics extends Controller
   {
      public function __construct()
      {
         parent::__construct();
         $this->model = $this->getModel('Topic');
      }

      public function index() : void
      {
         $topics = $this->model->getTopics();
         $this->view->render('topics/index', ['topics' => $topics]);
      }

      public function topic() : void
      {
         if($this->redirectIfNotLoggedIn())
         {
            return;
         }
         $this->view->render('topics/topic');
      }

      public function create() : void
      {
         if($this->redirectIfNotLoggedIn())
         {
            return;
         }
         $data = [
            'nameError' => '',
            'descriptionError' => '',
            'datePostedError' => '',
            'imageError' => '',
            'name' => '',
            'description' => '',
            'datePosted' => '',
            'user' => '',
            'image' => ''
         ];

         if($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         }

         $this->view->render('topics/create');
      }

      public function edit() : void
      {
         if($this->redirectIfNotLoggedIn())
         {
            return;
         }
         $this->view->render('topics/edit');
      }

      public function delete() : void
      {
         if($this->redirectIfNotLoggedIn())
         {
            return;
         }
         $this->view->render('topics/delete');
      }

      private function redirectIfNotLoggedIn() : bool
      {
         if (!isLoggedIn())
         {
            (new ControllerErrorPages())->restricted();
            return true;
         }
         return false;
      }
   }