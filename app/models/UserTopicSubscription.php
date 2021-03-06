<?php

declare(strict_types=1);

class UserTopicSubscription extends Model
{
   public function __construct()
   {
      parent::__construct();
      $this->TABLE_NAME = 'userTopicSubscription';
   }

   public function getSubscriptionsFromUser(int $userId): array
   {
      $sql = "select a.topic, a.subscribedSince, c.name as topicTitle from $this->TABLE_NAME a
      inner join user b on a.`user` = b.id
      inner join topic c on a.topic = c.id
      where b.id = :userId
      order by a.subscribedSince desc;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function userIsSubscribedToTopic(int $userId, int $topicId): bool
   {
      $sql = "select count(*) as count from $this->TABLE_NAME where `user` = :userId and topic = :topicId;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId);
      $statement->bindParam(':topicId', $topicId);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_OBJ);
      // cursed
      return $result[0]->count > 0;
   }

   public function getSubscribedUsers(int $topicId): ?array
   {
      $sql = "select b.`user` as id from topic a
      inner join $this->TABLE_NAME b on a.id = b.topic
      where a.id = :topicId;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':topicId', $topicId);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function subscribe(int $userId, int $topicId): bool
   {
      $sql = "insert into $this->TABLE_NAME (`user`, topic, subscribedSince) values (:userId, :topicId, now())";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId);
      $statement->bindParam(':topicId', $topicId);
      return $statement->execute();
   }

   public function unsubscribe(int $userId, int $topicId): bool
   {
      $sql = "delete from $this->TABLE_NAME where `user` = :userId and topic = :topicId";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':userId', $userId);
      $statement->bindParam(':topicId', $topicId);
      return $statement->execute();
   }
}
