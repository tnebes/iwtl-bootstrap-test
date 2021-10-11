<?php

declare(strict_types=1);

class Database
{
   private $dbHost = DB_HOST;
   private $dbUser = DB_USER;
   private $dbPass = DB_PASS;
   private $dbName = DB_NAME;

   private $statement;
   protected $dbHandler;
   private $error;

   private static $instance;

   private function __construct()
   {
      $connection = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
      $options = array(
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_PERSISTENT => true
      );
      try {
         $this->dbHandler = new PDO($connection, $this->dbUser, $this->dbPass, $options);
      } catch (PDOException $e) {
         // TODO: find a more secure way to handle this
         $this->error = $e->getMessage();
         Helper::getInstance()->debugDisplay($this->error);
      }
   }

   /**
    * Get the value of dbHandler
    */
   public function getDbHandler(): ?PDO
   {
      return $this->dbHandler;
   }

   public static function getInstance(): Database
   {
      if (!isset(self::$instance)) {
         self::$instance = new Database();
      }
      return self::$instance;
   }

   public function query(string $sql): void
   {
      $this->statement = $this->dbHandler->prepare($sql);
   }

   public function bind($parameter, $value, $type = null): void
   {
      switch (is_null($type)) {
         case is_int($value):
            $type = PDO::PARAM_INT;
            break;
         case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
         case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
         default:
            $type = PDO::PARAM_STR;
      }
      $this->statement->bindValue($parameter, $value, $type);
   }

   public function execute(): bool
   {
      return $this->statement->execute();
   }

   public function resultSet(): array
   {
      $this->execute();
      return $this->statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function single(): stdClass
   {
      $this->execute();
      return $this->statement->fetch(PDO::FETCH_OBJ);
   }

   public function rowCount(): int
   {
      $this->execute();
      return $this->statement->rowCount();
   }
}
