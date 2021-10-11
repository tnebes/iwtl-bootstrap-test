<?php

declare(strict_types=1);

class Topic extends Model
{
   public function __construct()
   {
      parent::__construct();
      $this->TABLE_NAME = 'topic';
   }

   // TODO: add image.
   /**
    * Unlike similar methods in the parent class, this method returns the int id of the created row.
    */
   public function createTopic(string $name, string $description, string $datePosted, int $user): int
   {
      $this->create($this->TABLE_NAME, ['name', 'description', 'datePosted', 'user'], [$name, $description, $datePosted, $user]);
      // cursed
      return (int) $this->read($this->TABLE_NAME, ['id'], ['name', 'description', 'datePosted', 'user'], [$name, $description, $datePosted, $user])[0]->id;
   }

   public function getTopics(int $from, int $to): array
   {
      $sql = "SELECT a.id, a.name, a.description, a.datePosted, a.user, image, b.username FROM $this->TABLE_NAME a
      inner join user b on a.`user` = b.id
      order by datePosted desc
      limit :from, :to;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':from', $from, PDO::PARAM_INT);
      $statement->bindParam(':to', $to, PDO::PARAM_INT);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getTopicsByUser(int $userId): array
   {
      return [];
   }

   public function getTopicById(int $id): ?stdClass
   {
      $sql = "SELECT a.id, a.name, a.description, a.datePosted, a.user, image, b.username FROM $this->TABLE_NAME a
      inner join user b on a.`user` = b.id
      where a.id = :topicId;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':topicId', $id, PDO::PARAM_INT);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ)[0] ?? null;
   }

   public function updateTopic(stdClass $topic): int
   {
      $this->update($this->TABLE_NAME, ['name', 'description', 'datePosted', 'user'], [$topic->name, $topic->description, $topic->datePosted, $topic->user], ['id'], [(int) $topic->id]);
      return (int) $topic->id;
   }

   public function deleteTopicById(int $id): bool
   {
      // TODO: implement an admin check so that admins cannot be deleted by using getIsAdmin();
      return $this->delete($this->TABLE_NAME, ['id'], [$id]);
   }
}
