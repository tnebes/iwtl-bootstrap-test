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

   public function getTopics(): array
   {
      return $this->read($this->TABLE_NAME, ['*'], null, null,);
   }

   public function getTopicsByUser(int $userId): array
   {
      return [];
   }

   public function getTopicById(int $id): ?stdClass
   {
      return null;
   }

   public function getTopicsBySubscription(int $subscriptionId): array
   {
      return [];
   }

   public function editTopicById(stdClass $topic): bool
   {

      return false;
   }

   public function deleteTopicById(int $id): bool
   {
      return false;
   }
}
