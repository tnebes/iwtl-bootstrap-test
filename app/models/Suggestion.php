<?php

declare(strict_types=1);

class Suggestion extends Model
{
   public function __construct()
   {
      parent::__construct();
      $this->TABLE_NAME = 'suggestion';
   }

   public function insert(stdClass $suggestion): bool
   {
      $sql = "INSERT INTO $this->TABLE_NAME VALUES (null, :user, :title, :topic, :datePosted, :shortDescription, :longDescription, :image)";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':user', $suggestion->user);
      $statement->bindParam(':title', $suggestion->title);
      $statement->bindParam(':topic', $suggestion->topic);
      $statement->bindParam(':datePosted', $suggestion->datePosted);
      $statement->bindParam(':shortDescription', $suggestion->shortDescription);
      $statement->bindParam(':longDescription', $suggestion->longDescription);
      $statement->bindParam(':image', $suggestion->image);
      return $statement->execute();
   }

   public function getAll(): array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME";
      $statement = $this->dbHandler->prepare($sql);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getById(int $id): ?stdClass
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE id = :id";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':id', $id);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ)[0];
   }

   public function getSuggestionsByTopicId(int $topicId)
   {
      // TODO: update this to show the most upvoted things.
      $sql = "select a.id, a.`user`, a.title, a.topic, a.datePosted, a.shortDescription, a.longDescription, b.username, c.filePath from $this->TABLE_NAME a 
      inner join user b on a.`user` = b.id
      left join image c on a.image = c.id
      where a.topic = :topicId
      order by (select sum(userScore) from userSuggestionReview c where a.id = c.suggestion) desc, a.datePosted desc;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':topicId', $topicId);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getNumTopicsByTopicId(int $topicId, int $numb)
   {
      // TODO: update this to show the most upvoted things.
      $sql = "select a.id, a.`user`, a.title, a.topic, a.datePosted, a.shortDescription, a.longDescription, b.username, c.filePath from $this->TABLE_NAME a 
      inner join user b on a.`user` = b.id
      left join image c on a.image = c.id
      where a.topic = :topicId
      order by (select sum(userScore) from userSuggestionReview c where a.id = c.suggestion) desc, a.datePosted desc
      limit :numb;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':topicId', $topicId);
      $statement->bindParam(':numb', $numb, PDO::PARAM_INT);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByUser(int $user): array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE user = :user";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':user', $user);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByTopic(int $topic): array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE topic = :topic";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':topic', $topic);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByTitle(string $title): array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE title = :title";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':title', $title);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByShortDescription(string $shortDescription): array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE shortDescription = :shortDescription";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':shortDescription', $shortDescription);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByLongDescription(string $longDescription): array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE longDescription = :longDescription";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':longDescription', $longDescription);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function myUpdate(stdClass $suggestion): bool
   {
      $sql = "UPDATE $this->TABLE_NAME SET user = :user, title = :title, topic = :topic, datePosted = :datePosted, shortDescription = :shortDescription, longDescription = :longDescription image=:image WHERE id = :id";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':user', $suggestion->user);
      $statement->bindParam(':title', $suggestion->title);
      $statement->bindParam(':topic', $suggestion->topic);
      $statement->bindParam(':datePosted', $suggestion->datePosted);
      $statement->bindParam(':shortDescription', $suggestion->shortDescription);
      $statement->bindParam(':longDescription', $suggestion->longDescription);
      $statement->bindParam(':image', $suggestion->image);
      $statement->bindParam(':id', $suggestion->id);
      return $statement->execute();
   }

   public function myDelete(int $id): bool
   {
      $this->dbHandler->beginTransaction();

      $sql = "delete from userSuggestionReview where suggestion = :suggestionId;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':suggestionId', $id);
      $statement->execute();

      $sql = "delete from suggestion where id = :suggestionId;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':suggestionId', $id);
      $statement->execute();

      $sql = "delete from image where id in (select image from $this->TABLE_NAME where id = :suggestionId)";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':suggestionId', $id);
      $statement->execute();

      return $this->dbHandler->commit();
   }
}
