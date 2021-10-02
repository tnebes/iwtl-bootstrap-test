<?php

declare(strict_types=1);

class Suggestion extends Model
{
   public function __construct()
   {
      parent::__construct();
      $this->TABLE_NAME = 'suggestion';
   }

   public function insert(stdClass $suggestion) : bool
   {
      $sql = "INSERT INTO $this->TABLE_NAME VALUES (:user, :title, :topic, :datePosted, :shortDescription, :longDescription)";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':user', $suggestion->user);
      $statement->bindParam(':title', $suggestion->title);
      $statement->bindParam(':topic', $suggestion->topic);
      $statement->bindParam(':datePosted', $suggestion->datePosted);
      $statement->bindParam(':shortDescription', $suggestion->shortDescription);
      $statement->bindParam(':longDescription', $suggestion->longDescription);
      return $statement->execute();
   }

   public function getAll() : array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME";
      $statement = $this->dbHandler->prepare($sql);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getById($id) : array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE id = :id";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':id', $id);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByUser($user) : array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE user = :user";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':user', $user);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByTopic($topic) : array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE topic = :topic";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':topic', $topic);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByTitle($title) : array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE title = :title";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':title', $title);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByShortDescription($shortDescription) : array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE shortDescription = :shortDescription";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':shortDescription', $shortDescription);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function getByLongDescription($longDescription) : array
   {
      $sql = "SELECT * FROM $this->TABLE_NAME WHERE longDescription = :longDescription";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':longDescription', $longDescription);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function myUpdate(stdClass $suggestion) : bool
   {
      $sql = "UPDATE $this->TABLE_NAME SET user = :user, title = :title, topic = :topic, datePosted = :datePosted, shortDescription = :shortDescription, longDescription = :longDescription WHERE id = :id";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':user', $suggestion->user);
      $statement->bindParam(':title', $suggestion->title);
      $statement->bindParam(':topic', $suggestion->topic);
      $statement->bindParam(':datePosted', $suggestion->datePosted);
      $statement->bindParam(':shortDescription', $suggestion->shortDescription);
      $statement->bindParam(':longDescription', $suggestion->longDescription);
      $statement->bindParam(':id', $suggestion->id);
      return $statement->execute();
   }

   public function myDelete($id) : bool
   {
      $sql = "DELETE FROM $this->TABLE_NAME WHERE id = :id";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':id', $id);
      return $statement->execute();
   }
}

