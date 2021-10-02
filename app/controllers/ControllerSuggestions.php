<?php

declare(strict_types=1);

class ControllerSuggestions extends Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->model = $this->getModel('Suggestion');
      $helper = Helper::getInstance();
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
         $data['topicTitle'] = trim($_POST['topicTitle']);
         $data['topicShortDescription'] = trim($_POST['topicShortDescription']);
         $data['topicLongDescription'] = trim($_POST['topicLongDescription']);
         $data['topicSuggesterId'] = $_SESSION['id'];
         
         $data['topicTitleError'] = $this->validateTopicTitle($data['topicTitle']);
         $data['topicShortDescriptionError'] = $this->validateTopicShortDescription($data['topicShortDescription']);
         $data['topicLongDescriptionError'] = $this->validateTopicLongDescription($data['topicLongDescription']);

         if ($_POST['topicTitle'] !== '' && $_POST['topicShortDescription'] !== '' && $_POST['topicLongDescription'] !== '') {
            $this->model->create($_POST['topicTitle'], $_POST['topicShortDescription'], $_POST['topicLongDescription'], $topicId);
            header('location:' . URL_ROOT . '/topics/view/' . $topicId);
         }
         $this->view->render('createSuggestion', $data);
         return;
      } else {
         $this->view->render('suggestions/create', $data);
      }
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

   // public function store()
   // {
   //    $topicId = func_get_arg(0);
   //    if ($topicId === null)
   //    {
   //       header('location:' . URL_ROOT . '/errorPages/notFound');
   //       return;
   //    }
   //    $topic = (new Topic())->getTopicById($topicId);
   //    if ($topic === null)
   //    {
   //       header('location:' . URL_ROOT . '/errorPages/notFound');
   //       return;
   //    }
   //    $data = [
   //       'topic_id' => $topicId,
   //       'user_id' => $_SESSION['user_id'],
   //       'title' => $_POST['title'],
   //       'description' => $_POST['description']
   //    ];
   //    $suggestion = new Suggestion($data);
   //    $suggestion->save();
   //    header('location:' . URL_ROOT . '/topics/show/' . $topicId);
   // }

   // public function show()
   // {
   //    $suggestionId = func_get_arg(0);
   //    if ($suggestionId === null)
   //    {
   //       header('location:' . URL_ROOT . '/errorPages/notFound');
   //       return;
   //    }
   //    $suggestion = (new Suggestion())->getSuggestionById($suggestionId);
   //    if ($suggestion === null)
   //    {
   //       header('location:' . URL_ROOT . '/errorPages/notFound');
   //       return;
   //    }
   //    $this->view->render('suggestions/show', ['suggestion' => $suggestion]);
   // }

   // public function edit()
   // {
   //    $suggestionId = func_get_arg(0);
   //    if ($suggestionId === null)
   //    {
   //       header('location:' . URL_ROOT . '/errorPages/notFound');
   //       return;
   //    }
   //    $suggestion = (new Suggestion())->getSuggestionById($suggestionId);

   // }
}
