<?php

class UserSuggestionReview extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->TABLE_NAME = 'userSuggestionReview';
    }

    /**
     * @param int $userId
     * @param int $suggestionId
     * @param int $reviewScore
     * @return bool topic reviewed with the $reviewScore
     */
    public function isReviewedSuggestion(int $userId, int $suggestionId, int $reviewScore = 0) : bool
    {
        // TODO: implement
        return false;
    }

    public function updateSuggestionReview(int $userId, int $suggestionId, int $int)
    {
    }

    public function createSuggestionReview(int $userId, int $suggestionId, int $int)
    {
    }




}