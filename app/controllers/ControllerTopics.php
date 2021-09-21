<?php

declare(strict_types=1);

class ControllerTopics extends Controller
{
   private $helper = null;

   public function __construct()
   {
      parent::__construct();
      $this->model = $this->getModel('Topic');
      $this->helper = Helper::getInstance();
   }

   public function index(): void
   {
      $topics = $this->model->getTopics();
      $this->view->render('topics/index', ['topics' => $topics]);
   }

   public function topic(): void
   {
      if ($this->redirectIfNotLoggedIn()) {
         return;
      }
      $this->view->render('topics/topic');
   }

   public function create(): void
   {
      if ($this->redirectIfNotLoggedIn()) {
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

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $data['name'] = $_POST['name'];
         $data['description'] = $_POST['description'];
         $data['datePosted'] = (new DateTime())->format('Y-m-d H:i:s');
         $data['user'] = $_SESSION['user']['id'];
         $data['image'] = $_POST['image']; // TODO:
         unset($_POST);
      }

      $this->view->render('topics/create');
   }

   public function edit(): void
   {
      if ($this->redirectIfNotLoggedIn()) {
         return;
      }
      $this->view->render('topics/edit');
   }

   public function delete(): void
   {
      if ($this->redirectIfNotLoggedIn()) {
         return;
      }
      $this->view->render('topics/delete');
   }

}
