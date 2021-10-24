<?php

declare(strict_types=1);

class ModelPagination extends Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function getEntries(string $tableName): ?int
   {
      $sql = "select count(*) from $tableName";
      $statement = $this->dbHandler->prepare($sql);
      $statement->execute();
      // cursed
      return (int) $statement->fetch()[0];
   }
}
