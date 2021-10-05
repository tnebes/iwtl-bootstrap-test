<?php

declare(strict_types=1);

class UserTopicSubscription extends Model
{
   public function __construct()
   {
      parent::__construct();
      $this->TABLE_NAME = 'usertopicsubscription';
   }

   public function getSubscriptionsFromUser(int $userId) : array
   {
      $sql = "select a.topic, a.subscribedSince, c.name as topicTitle from usertopicsubscription a
      inner join user b on a.`user` = b.id
      inner join topic c on a.topic = c.id
      where b.id = :userId
      order by a.subscribedSince desc;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function userIsSubscribedToTopic(int $userId, int $topicId) : bool
   {
      $sql = "select count(*) as count from usertopicsubscription where `user` = :userId and topic = :topicId;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId);
      $statement->bindParam(':topicId', $topicId);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_OBJ);
      return $result->count > 0;
   }

   public function subscribe(int $userId, int $topicId) : bool
   {
      $sql = "insert into usertopicsubscription (`user`, topic, subscribedSince) values (:userId, :topicId, now())";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId);
      $statement->bindParam(':topicId', $topicId);
      return $statement->execute();
   }

   public function unsubscribe(int $userId, int $topicId) : bool
   {
      $sql = "delete from usertopicsubscription where `user` = :userId and topic = :topicId";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId);
      $statement->bindParam(':topicId', $topicId);
      return $statement->execute();
   }
   
}