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
      $topicId = (int) func_get_arg(0);
      if ($topicId !== null && is_int($topicId))
      {
         $this->model->getTopicById($topicId) ? $this->view->render('topics/topic', ['topic' => $this->model->getTopicById($topicId)]) : header('location: ' . URL_ROOT . '/errorPages/notFound');
         return;
      }
      else
      {
         header('location: ' . URL_ROOT . '/errorPages/notFound');
         return;
      }
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
         $data['imageError'] = ''; // TODO: $this->validateImage($data['image']);

         if ($data['nameError'] !== '' || $data['descriptionError'] !== '' || $data['imageError'] !== '')
         {
            $this->view->render('topics/create', $data);
            return;
         }
         $topicId = $this->model->createTopic($data['name'], $data['description'], $data['datePosted'], $data['user']);
         $this->topic($topicId);
         return;
      }
      $this->view->render('topics/create', $data);
   }

   public function edit(): void
   {
      $userId = (int) $_SESSION['id'];
      $topicId = (int) func_get_arg(0);
      $topic = null;
      if ($topicId !== null && is_int($topicId))
      {
         $topic = $this->model->getTopicById($topicId);
      }
      if ($topic === null)
      {
         header('location: ' . URL_ROOT . '/errorPages/notFound');
         return;
      }
      if ($userId !== (int) $topic->user && !$this->helper->isAdmin())
      {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }
      $data = [
         'topic' => $topic,
         'nameError' => '',
         'descriptionError' => '',
         'imageError' => '',
         'name' => $topic->name,
         'description' => $topic->description,
         'user' => $topic->user,
         'image' => $topic->image
      ];
      if ($_SERVER['REQUEST_METHOD'] === 'POST')
      {
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $data['name'] = trim($_POST['name']);
         $data['description'] = trim($_POST['description']);
         $data['image'] = null; // TODO: add the image path or something
         $data['user'] = (int) $_SESSION['id'];
         $data['datePosted'] = $topic->datePosted;
         unset($_POST);

         $data['nameError'] = $this->validateName($data['name']);
         $data['descriptionError'] = $this->validateDescription($data['description']);        
         $data['imageError'] = ''; // TODO: $this->validateImage($data['image']);
         if ($data['nameError'] !== '' || $data['descriptionError'] !== '' || $data['imageError'] !== '')
         {
            $this->view->render('topics/edit', $data);
            return;
         }

         $topic->name = $data['name'];
         $topic->description = $data['description'];
         $topic->image = $data['image'];
         // TODO: redirect in header so that the user can go back.
         $this->topic($this->model->updateTopic($topic));
         return;
      }
      else
      {
         $this->view->render('topics/edit', $data);
      }
   }

   public function delete(): void
   {
      if ($this->redirectIfNotLoggedIn()) {
         return;
      }
      $userId = (int) $_SESSION['id'];
      $topicId = (int) func_get_arg(0);
      $topic = null;
      if ($topicId !== null && is_int($topicId))
      {
         $topic = $this->model->getTopicById($topicId);
      }
      if ($topic === null)
      {
         header('location: ' . URL_ROOT . '/errorPages/notFound');
         return;
      }
      if ($userId !== (int) $topic->user && !$this->helper->isAdmin())
      {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         if (isset($_POST['confirm']) && filter_var($_POST['confirm'], FILTER_VALIDATE_BOOLEAN)) {
            // TODO: add a check to see whether anything is tied to the topic
            $this->model->deleteTopicById($topicId);
         }
         $this->index();
         return;
      }
      $this->view->render('topics/delete', ['topic' => $topic]);
   }

   private function validateName(string $name): string
   {
      if (empty($name))
      {
         return 'Title cannot be empty';
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
      if (empty($description))
      {
         return 'Description cannot be empty';
      }
      if (strlen($description) < 12)
      {
         return 'Description must be at least 32 characters';
      }
      if (strlen($description) > 3000)
      {
         return 'Description must be less than 3000 characters';
      }
      return '';
   }

   private function validateImage(string $image): string
   {
      return '';
   }

}
