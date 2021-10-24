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
   public function isReviewedSuggestion(int $userId, int $suggestionId, int $reviewScore = 0): bool
   {
      $sql = "select count(*) from $this->TABLE_NAME where user = :userId and suggestion = :suggestionId";
      if ($reviewScore != 0) {
         $sql .= " and userScore = :reviewScore";
      }
      $sql .= ";";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
      $statement->bindParam(':suggestionId', $suggestionId, PDO::PARAM_INT);
      if ($reviewScore != 0) {
         $statement->bindParam(':reviewScore', $reviewScore, PDO::PARAM_INT);
      }
      $statement->execute();
      return $statement->fetchColumn() > 0;
   }

   /**
    * @param int $userId
    * @param int $suggestionId
    * @param int $reviewScore
    * @return bool
    */
   public function updateSuggestionReview(int $userId, int $suggestionId, int $reviewScore): bool
   {
      $sql = "update $this->TABLE_NAME set userScore = :reviewScore where user = :user and suggestion = :suggestion;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':user', $userId, PDO::PARAM_INT);
      $statement->bindParam(':suggestion', $suggestionId, PDO::PARAM_INT);
      $statement->bindParam(':reviewScore', $reviewScore, PDO::PARAM_INT);
      return $statement->execute();
   }

   /**
    * @param int $userId
    * @param int $suggestionId
    * @param int $reviewScore
    * @return bool
    */
   public function createSuggestionReview(int $userId, int $suggestionId, int $reviewScore): bool
   {
      $sql = "insert into $this->TABLE_NAME (user, suggestion, userScore) values (:user, :suggestion, :reviewScore);";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':user', $userId);
      $statement->bindParam(':suggestion', $suggestionId);
      $statement->bindParam(':reviewScore', $reviewScore);
      return $statement->execute();
   }

   /**
    * @param int $userId
    * @param int $suggestionId
    * @return bool
    */
   public function deleteReview(int $userId, int $suggestionId): bool
   {
      $sql = "delete from $this->TABLE_NAME where user = :userId and suggestion = :suggestionId;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
      $statement->bindParam(':suggestionId', $suggestionId, PDO::PARAM_INT);
      return $statement->execute();
   }

   /**
    * @param int $userSuggestionReviewId
    * @return int
    */
   public function getReviewScore(int $userSuggestionReviewId): int
   {
      $sql = "select sum(a.userScore) as score from $this->TABLE_NAME a where suggestion = :suggestionId;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':suggestionId', $userSuggestionReviewId);
      $statement->execute();
      return $statement->fetch()[0] ?? 0;
   }

   public function getReviewByUser(int $userId, int $suggestionId): ?int
   {
      $sql = "select userScore from $this->TABLE_NAME where user = :userId and suggestion = :suggestionId;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId);
      $statement->bindParam(':suggestionId', $suggestionId);
      $statement->execute();
      return $statement->fetch()[0] ?? null;
   }
}
