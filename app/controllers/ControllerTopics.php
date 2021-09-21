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
         $data['name'] = trim($_POST['name']);
         $data['description'] = trim($_POST['description']);
         $data['datePosted'] = (new DateTime())->format('Y-m-d H:i:s');
         $data['user'] = (int) $_SESSION['id'];
         $data['image'] = null; // TODO: add the image path or something
         unset($_POST);

         $data['nameError'] = $this->validateName($data['name']);
         $data['descriptionError'] = $this->validateDescription($data['description']);        
         $data['imageError'] = null; // TODO: $this->validateImage($data['image']);

         if ($data['nameError'] !== '' && $data['descriptionError'] !== '' && $data['imageError'] !== '')
         {
            $this->view->render('topics/create', $data);
            return;
         }
         $this->model->createTopic($data['name'], $data['description'], $data['datePosted'], $data['user']);
         // TODO: redirect to created topic.
         $this->index();
         return;
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

   private function validateName(string $name): string
   {
      if (empty($name))
      {
         return 'Name cannot be empty';
      }
      if (strlen($name) < 12)
      {
         return 'Title must be at least 12 characters';
      }
      if (strlen($name) > 255)
      {
         return 'Title must be less than 255 characters';
      }
      return '';
   }

   private function validateDescription(string $description): string
   {

      return '';
   }

   private function validateImage(string $image): string
   {
      return '';
   }

}
