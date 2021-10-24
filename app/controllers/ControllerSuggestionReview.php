<?php

declare(strict_types=1);

class ControllerSuggestionReview extends Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->model = $this->getModel('UserSuggestionReview');
   }

   public function reviewPositive(): void
   {
      if (!$this->helper->isLoggedIn()) {
         // header('location: ' . URL_ROOT . '/errorPages/restricted');
         echo json_encode(['status' => 'error', 'message' => 'You must be logged in to review a suggestion']);
         return;
      }
      $suggestionId = (int) func_get_arg(0);
      if (!$suggestionId || !(new Suggestion())->getById($suggestionId)) {
         // header('location: ' . URL_ROOT . '/errorPages/internalError');
         echo json_encode(['status' => 'error', 'message' => 'Suggestion not found']);
         return;
      }
      $userId = (int) $_SESSION['id'];
      $redirect = $_SERVER['HTTP_REFERER'];
      $positiveReviewExists = $this->model->isReviewedSuggestion($userId, $suggestionId, 1);
      if ($positiveReviewExists) {
         $this->model->deleteReview($userId, $suggestionId);
         // header('location: ' . $redirect);
         echo json_encode(['status' => 'success', 'message' => 'Review deleted', 'counter' => $this->model->getReviewScore($suggestionId)]);
         return;
      }
      $anyReviewExists = $this->model->isReviewedSuggestion($userId, $suggestionId);
      if ($anyReviewExists) {
         $this->model->updateSuggestionReview($userId, $suggestionId, 1);
      } else {
         $this->model->createSuggestionReview($userId, $suggestionId, 1);
      }
      // header('location: ' . $redirect);
      echo json_encode(['status' => 'success', 'message' => 'Review added', 'counter' => $this->model->getReviewScore($suggestionId)]);
   }

   public function reviewNegative(): void
   {
      if (!$this->helper->isLoggedIn()) {
         // header('location: ' . URL_ROOT . '/errorPages/restricted');
         echo json_encode(['status' => 'error', 'message' => 'You must be logged in to review a suggestion']);
         return;
      }
      $suggestionId = (int) func_get_arg(0);
      if (!$suggestionId || !(new Suggestion())->getById($suggestionId)) {
         // header('location: ' . URL_ROOT . '/errorPages/internalError');
         echo json_encode(['status' => 'error', 'message' => 'Suggestion not found']);
         return;
      }
      $userId = (int) $_SESSION['id'];
      $redirect = $_SERVER['HTTP_REFERER'];
      $negativeReviewExists = $this->model->isReviewedSuggestion($userId, $suggestionId, -1);
      if ($negativeReviewExists) {
         $this->model->deleteReview($userId, $suggestionId);
         // header('location: ' . $redirect);
         echo json_encode(['status' => 'success', 'message' => 'Review deleted', 'counter' => $this->model->getReviewScore($suggestionId)]);
         return;
      }
      $anyReviewExists = $this->model->isReviewedSuggestion($userId, $suggestionId);
      if ($anyReviewExists) {
         $this->model->updateSuggestionReview($userId, $suggestionId, -1);
      } else {
         $this->model->createSuggestionReview($userId, $suggestionId, -1);
      }
      // header('location: ' . $redirect);
      echo json_encode(['status' => 'success', 'message' => 'Review added', 'counter' => $this->model->getReviewScore($suggestionId)]);
   }
}
