<?php declare(strict_types = 1);

   Class Topic extends Model
   {
      public function __construct()
      {
         parent::__construct();
         $this->TABLE_NAME = 'topic';
      }

      public function createTopic(stdClass $topic) : bool
      {
         return false;
      }

      public function getTopics() : array
      {
         return $this->read($this->TABLE_NAME, ['*'], null, null,);
      }

      public function getTopicsByUser(int $userId) : array
      {
         return [];
      }

      public function getTopicById(int $id) : ?stdClass
      {
         return null;
      }

      public function getTopicsBySubscription(int $subscriptionId) : array
      {
         return [];
      }

      public function editTopicById(stdClass $topic) : bool
      {
         
         return false;
      }

      public function deleteTopicById(int $id) : bool
      {
         return false;
      }

   }