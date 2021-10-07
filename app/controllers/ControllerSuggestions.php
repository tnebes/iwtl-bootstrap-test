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
      if ($this->redirectIfNotLoggedIn()) {
         return;
      }
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
            'topicId' => $topicId,
            'suggestionTitle' => '',
            'suggestionShortDescription' => '',
            'suggestionLongDescription' => '',

            'suggestionTitleError' => '',
            'suggestionShortDescriptionError' => '',
            'suggestionLongDescriptionError' => ''
         ];

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && filter_var($_POST['submit'], FILTER_VALIDATE_BOOLEAN)) {
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $data['suggestionTitle'] = trim($_POST['title']);
         $data['suggestionShortDescription'] = trim($_POST['shortDescription']);
         $data['suggestionLongDescription'] = trim($_POST['longDescription']);
         $data['topicSuggesterId'] = (int) $_SESSION['id'];
         
         $data['suggestionTitleError'] = $this->validateSuggestionTitle($data['suggestionTitle']);
         $data['suggestionShortDescriptionError'] = $this->validateSuggestionShortDescription($data['suggestionShortDescription']);
         $data['suggestionLongDescriptionError'] = $this->validateSuggestionLongDescription($data['suggestionLongDescription']);

         if ($data['suggestionTitleError'] == '' && $data['suggestionShortDescription'] == '' && $data['suggestionLongDescription'] == '') {
            $suggestion = new stdClass;
            $suggestion->user = $data['topicSuggesterId'];
            $suggestion->title = $data['suggestionTitle'];
            $suggestion->topic = $data['topicId'];
            $suggestion->datePosted = (new DateTime())->format('Y-m-d H:i:s');
            $suggestion->shortDescription = $data['suggestionShortDescription'];
            $suggestion->longDescription = $data['suggestionLongDescription'];
            
            $this->model->insert($suggestion);
         }
         else
         {
            $this->view->render('suggestions/create', $data);
         }
         header('location: ' . URL_ROOT . '/topics/topic/' . $topicId);
         return;
      } else {
         $this->view->render('suggestions/create', $data);
      }
   }

   public function edit() : void
   {
      if ($this->redirectIfNotLoggedIn()) {
         return;
      }
      $suggestionId = (int) func_get_arg(0);
      if ($suggestionId === null) {
         header('location:' . URL_ROOT . '/errorPages/notFound');
         return;
      }
      $suggestion = $this->model->getById($suggestionId)[0];
      if ($suggestion === null) {
         header('location:' . URL_ROOT . '/errorPages/internalError');
         return;
      }
      $topic = (new Topic())->getTopicById((int) $suggestion->topic);
      if ($topic === null) {
         header('location:' . URL_ROOT . '/errorPages/internalError');
         return;
      }
      if ($suggestion->user != $_SESSION['id'] && !$this->helper->isAdmin())
      {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }

      $data =
         [
            'redirect' => $_SERVER['HTTP_REFERER'],
            'topic' => $topic,
            'topicSuggesterId' => '',
            'topicId' => $topic->id,
            'suggestionTitle' => $suggestion->title,
            'suggestionShortDescription' => $suggestion->shortDescription,
            'suggestionLongDescription' => $suggestion->longDescription,

            'suggestionTitleError' => '',
            'suggestionShortDescriptionError' => '',
            'suggestionLongDescriptionError' => ''
         ];

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && filter_var($_POST['submit'], FILTER_VALIDATE_BOOLEAN)) {
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $data['suggestionTitle'] = trim($_POST['title']);
         $data['suggestionShortDescription'] = trim($_POST['shortDescription']);
         $data['suggestionLongDescription'] = trim($_POST['longDescription']);
         $data['topicSuggesterId'] = (int) $_SESSION['id'];
         
         $data['suggestionTitleError'] = $this->validateSuggestionTitle($data['suggestionTitle']);
         $data['suggestionShortDescriptionError'] = $this->validateSuggestionShortDescription($data['suggestionShortDescription']);
         $data['suggestionLongDescriptionError'] = $this->validateSuggestionLongDescription($data['suggestionLongDescription']);

         if (empty($data['suggestionTitleError']) && empty($data['suggestionShortDescriptionError']) && empty($data['suggestionLongDescriptionError'])) {
            $suggestion->title = $data['suggestionTitle'];
            $suggestion->shortDescription = $data['suggestionShortDescription'];
            $suggestion->longDescription = $data['suggestionLongDescription'];
            
            $this->model->myUpdate($suggestion);
            // TODO: fix the redirect
            header('location: ' . $data['redirect'] ?? URL_ROOT . '/topics/topic/' . $topic->id);
            return;
         }
         else
         {
            $this->view->render('suggestions/edit', $data);
            return;
         }
         header('location: ' . URL_ROOT . '/topics/topic/' . $topic->id);
         return;
      } else {
         $this->view->render('suggestions/edit', $data);
      }
   }

   public function delete() : void
   {
      if ($this->redirectIfNotLoggedIn()) {
         return;
      }
      $suggestionId = (int) func_get_arg(0);
      if ($suggestionId === null) {
         header('location:' . URL_ROOT . '/errorPages/notFound');
         return;
      }
      $suggestion = $this->model->getById($suggestionId)[0];
      if ($suggestion === null) {
         header('location:' . URL_ROOT . '/errorPages/internalError');
         return;
      }
      if ($suggestion->user != $_SESSION['id'] && !$this->helper->isAdmin())
      {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }      

      $data = [
         'redirect' => $_POST['redirect'] ?? $_SERVER['HTTP_REFERER'],
         'suggestion' => $suggestion
      ];

      if ($_SERVER['REQUEST_METHOD'] === 'POST')
      {
         if (isset($_POST['confirm']) && filter_var($_POST['confirm'], FILTER_VALIDATE_BOOLEAN)) 
         {
            // $this->model->myDelete((int) $suggestion->id);
            echo 'deleted DELETED DELETED.';
            header('location: ' . $data['redirect'] ?? $_SERVER['HTTP_REFERER']);
            return;
         }
      }
      $this->view->render('suggestions/delete', $data);
   }

   private function validateSuggestionTitle(string $topicTitle) : string
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

   private function validateSuggestionShortDescription(string $topicTitle) : string
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

   private function validateSuggestionLongDescription(string $topicTitle) : string
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
