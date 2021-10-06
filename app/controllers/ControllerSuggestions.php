<?php

declare(strict_types=1);

class ControllerSuggestions extends Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->model = $this->getModel('Suggestion');
   }

   public function index(): void
   {
      header('location:' . URL_ROOT . '/errorPages/notFound');
   }

   public function create(): void
   {
      $topicId = (int) func_get_arg(0);
      if ($topicId === null) {
         header('location:' . URL_ROOT . '/errorPages/notFound');
         return;
      }
      $topic = (new Topic())->getTopicById($topicId);
      if ($topic === null) {
         header('location:' . URL_ROOT . '/errorPages/internalError');
         return;
      }

      $data =
         [
            'topic' => $topic,
            'topicSuggesterId' => '',
            'topicTitle' => '',
            'topicId' => $topicId,
            'topicShortDescription' => '',
            'topicLongDescription' => '',

            'topicTitleError' => '',
            'topicShortDescriptionError' => '',
            'topicLongDescriptionError' => ''
         ];

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && filter_var($_POST['submit'], FILTER_VALIDATE_BOOLEAN)) {
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $data['topicTitle'] = trim($_POST['title']);
         $data['topicShortDescription'] = trim($_POST['shortDescription']);
         $data['topicLongDescription'] = trim($_POST['longDescription']);
         $data['topicSuggesterId'] = (int) $_SESSION['id'];
         
         $data['topicTitleError'] = $this->validateTopicTitle($data['topicTitle']);
         $data['topicShortDescriptionError'] = $this->validateTopicShortDescription($data['topicShortDescription']);
         $data['topicLongDescriptionError'] = $this->validateTopicLongDescription($data['topicLongDescription']);

         if ($data['topicTitle'] !== '' && $data['topicShortDescription'] !== '' && $data['topicLongDescription'] !== '') {
            $suggestion = new stdClass;
            $suggestion->user = $data['topicSuggesterId'];
            $suggestion->title = $data['topicTitle'];
            $suggestion->topic = $data['topicId'];
            $suggestion->datePosted = (new DateTime())->format('Y-m-d H:i:s');
            $suggestion->shortDescription = $data['topicShortDescription'];
            $suggestion->longDescription = $data['topicLongDescription'];
            
            $this->model->insert($suggestion);
         }
         header('location: ' . URL_ROOT . '/topics/topic/' . $topicId);
         return;
      } else {
         $this->view->render('suggestions/create', $data);
      }
   }

   public function edit() : void
   {
      $data = [];
      $this->view->render('suggestions/edit', $data);
   }

   public function delete() : void
   {
      $data = [];
      $this->view->render('suggestions/delete', $data);
   }

   private function validateTopicTitle(string $topicTitle) : string
   {
      if (empty($topicTitle)) {
         return 'Title is required';
      }
      if (strlen($topicTitle) < 5)
      {
         return 'Title must be at least 5 characters long';
      }
      if (strlen($topicTitle) > 100) {
         return 'Title must be less than 100 characters';
      }
      return '';
   }

   private function validateTopicShortDescription(string $topicTitle) : string
   {
      if (empty($topicTitle)) {
         return 'Short description is required';
      }
      if (strlen($topicTitle) < 20)
      {
         return 'Short description must be at least 20 characters long';
      }
      if (strlen($topicTitle) > 1000) {
         return 'Short description must be less than 1000 characters';
      }
      return '';
   }

   private function validateTopicLongDescription(string $topicTitle) : string
   {
      // no further checking required if the long description is valid
      if (empty($topicTitle)) {
         return '';
      }
      if (strlen($topicTitle) < 20)
      {
         return 'Long description must be at least 20 characters long.';
      }
      if (strlen($topicTitle) > 10000) {
         return 'Long description must be less than 10000 characters.';
      }
      return '';
   }

}
