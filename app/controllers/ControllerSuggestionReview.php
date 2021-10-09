<?php

declare(strict_types = 1);

class ControllerSuggestionReview extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = $this->getModel('UserSuggestionReview');
    }

    public function reviewPositive() : void
    {
        if (!$this->helper->isLoggedIn())
        {
            header('location: ' . URL_ROOT . '/errorPages/restricted');
            return;
        }
        $suggestionId = (int) func_get_arg(0);
        if (!$suggestionId || !(new Suggestion())->getById($suggestionId))
        {
            header('location: ' . URL_ROOT . '/errorPages/internalError');
            return;
        }
        $userId = (int) $_SESSION['id'];
        $redirect = $_SERVER['HTTP_REFERER'];
        $positiveReviewExists = $this->model->isReviewedSuggestion($userId, $suggestionId, 1);
        if ($positiveReviewExists)
        {
            $this->model->deleteReview($userId, $suggestionId);
            header('location: ' . $redirect);
            return;
        }
        $anyReviewExists = $this->model->isReviewedSuggestion($userId, $suggestionId);
        if ($anyReviewExists)
        {
            $this->model->updateSuggestionReview($userId, $suggestionId, 1);
        }
        else
        {
            $this->model->createSuggestionReview($userId, $suggestionId, 1);
        }
        header('location: ' . $redirect);
    }

    public function reviewNegative() : void
    {
        if (!$this->helper->isLoggedIn())
        {
            header('location: ' . URL_ROOT . '/errorPages/restricted');
            return;
        }
        $suggestionId = (int) func_get_arg(0);
        if (!$suggestionId || !(new Suggestion())->getById($suggestionId))
        {
            header('location: ' . URL_ROOT . '/errorPages/internalError');
            return;
        }
        $userId = (int) $_SESSION['id'];
        $redirect = $_SERVER['HTTP_REFERER'];
        $negativeReviewExists = $this->model->isReviewedSuggestion($userId, $suggestionId, -1);
        if ($negativeReviewExists)
        {
            $this->model->deleteReview($userId, $suggestionId);
            header('location: ' . $redirect);
            return;
        }
        $anyReviewExists = $this->model->isReviewedSuggestion($userId, $suggestionId);
        if ($anyReviewExists)
        {
            $this->model->updateSuggestionReview($userId, $suggestionId, -1);
        }
        else
        {
            $this->model->createSuggestionReview($userId, $suggestionId, -1);
        }
        header('location: ' . $redirect);
    }

}