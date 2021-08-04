<?php declare(strict_types = 1);

   Class Database
   {
      private $dbHost = DB_HOST;
      private $dbUser = DB_USER;
      private $dbPass = DB_PASS;
      private $dbName = DB_NAME;

      private $statement;
      private $dbHandler;
      private $error;

      public function __construct()
      {
         $connection = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
         $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true
         );
         try
         {
            $this->dbHandler = new PDO($connection, $this->dbUser, $this->dbPass, $options);
         }
         catch (PDOException $e)
         {
            // TODO: find a more secure way to handle this
            $this->error = $e->getMessage();
            debugDisplay($this->error);
         }
      }

      public function query(string $sql) : void
      {
         $this->statement = $this->dbHandler->prepare($sql);
      }

      public function bind($parameter, $value, $type = null) : void
      {
         switch (is_null($type))
         {
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

      public function execute() : bool
      {
         return $this->statement->execute();
      }

      // TODO: do something here so that the object gets cast into its respective object
      public function resultSet() : array
      {
         $this->execute();
         return $this->statement->fetchAll(PDO::FETCH_OBJ);
      }

      public function single() : stdClass
      {
         $this->execute();
         return $this->statement->fetch(PDO::FETCH_OBJ);
      }

      public function rowCount() : int
      {
         $this->execute();
         return $this->statement->rowCount();
      }

   }