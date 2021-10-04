<?php

declare(strict_types=1);

abstract class Model
{
   protected $db;
   protected $TABLE_NAME;

   public function __construct()
   {
      $this->db = Database::getInstance();
      if (empty($this->db)) {
         die('Could not connect to database. Please check the connection data.');
      }
   }

   /**
    * Protected create function.
    * @return bool
    * @param tName is the table name in the SQL database
    * @param cols is the column(s) to be created
    * @param vals is the values to be inserted into the columns
    */
   protected function create(string $tName, array $cols, array $vals): bool
   {
      if (empty($tName)) {
         die('Table name not defined.');
      }

      if (empty($cols) || empty($vals)) {
         die('No columns or values specified');
      }

      if (count($cols) != count($vals)) {
         die('Too few arguments for creation');
      }

      $statement = 'INSERT INTO ';
      $statement .= $tName;
      $statement .= ' (';
      for ($i = 0; $i < count($cols); $i++) {
         $statement .= $cols[$i];
         if ($i < count($cols) - 1) {
            $statement .= ',';
         }
      }
      $statement .= ') ';
      $statement .= 'VALUES (';
      for ($i = 0; $i < count($vals); $i++) {
         $statement .= '?';
         if ($i < count($vals) - 1) {
            $statement .= ',';
         }
      }
      $statement .= ');';
      $this->db->query($statement);
      for ($i = 1; $i <= count($vals); $i++) {
         $this->db->bind($i, $vals[$i - 1]);
      }
      return $this->db->execute();
   }

   /**
    * Protected read function
    * @return array
    * @param tName table name
    * @param cols affected columns
    * @param criteria where criteria
    * @param criteriaVals where criteria values
    * SELECT cols FROM tName WHERE criterion0 = criteriaVal0 OR criterion1 = criterionVal1...
    */
   protected function read(string $tName, array $cols, ?array $criteria, ?array $criteriaVals): array
   {
      if (empty($tName)) {
         die('Table name not defined.');
      }
      if (empty($cols)) {
         die('Columns not defined.');
      }

      $statement = 'SELECT ';
      if (count($cols) === 1 && $cols[0] == '*') {
         $statement .= $cols[0] . ' ';
      } else {
         for ($i = 0; $i < count($cols); $i++) {
            $statement .= $cols[$i];
            if ($i < count($cols) - 1) {
               $statement .= ',';
            }
         }
      }

      $statement .= ' FROM ';
      $statement .= $tName;
      if (!empty($criteria) && !empty($criteriaVals)) {
         $statement .= ' WHERE ';
         for ($i = 0; $i < count($criteria); $i++) {
            $statement .= $criteria[$i] . '=' . '?';
            if ($i != count($criteria) - 1) {
               $statement .= ' AND ';
            }
         }
      }
      $statement .= ';';
      $this->db->query($statement);

      if (!empty($criteria) && !empty($criteriaVals)) {
         for ($i = 1; $i <= count($criteriaVals); $i++) {
            $this->db->bind($i, $criteriaVals[$i - 1]);
         }
      }
      return $this->db->resultSet();
   }

   protected function readSingle(string $tName, array $cols, ?array $criteria, ?array $criteriaVals): ?stdClass
   {
      $results = $this->read($tName, $cols, $criteria, $criteriaVals);
      return !empty($results) ? $results[0] : null;
   }


   protected function update(string $tName, array $cols, array $vals, array $criteria, array $criteriaVals): bool
   {
      if (empty($tName)) {
         die('Table name not defined.');
      }
      if (count($criteria) != count($criteriaVals)) {
         die('Too few criteria or criteria values for update');
      }
      if (count($cols) != count($vals))
      {
         die('Too few columns or values for update');
      }
      $index = 1;
      $statement = 'UPDATE ';
      $statement .= $tName;
      $statement .= ' SET ';
      foreach ($cols as $col) {
         $statement .= $col . '=' . '?';
         if ($index++ <= count($cols) - 1) {
            $statement .= ',';
         }
      }
      $index = 1;

      $statement .= ' WHERE ';
      for ($i = 0; $i < count($criteria); $i++) {
         $statement .= $criteria[$i] . '=' . '?';
         if ($i < count($criteria) - 1) {
            $statement .= ' AND ';
         }
      }
      $statement .= ';';
      $this->db->query($statement);

      foreach ($vals as $value) {
         $this->db->bind($index++, $value);
      }
      unset($index);
      for ($i = 1; $i <= count($criteriaVals); $i++) {
         $this->db->bind($i + count($vals), $criteriaVals[$i - 1]);
      }
      return $this->db->execute();
   }

   protected function delete(string $tName, ?array $criteria, ?array $criteriaVals): bool
   {
      if (empty($tName)) {
         die('Table name not defined.');
      }
      if (empty($criteria) && empty($criteriaVals)) {
         die('No criteria or values specified');
      }
      $statement = 'DELETE FROM ';
      $statement .= $tName;
      if (!empty($criteria) && !empty($criteriaVals)) {
         $statement .= ' WHERE ';
         for ($i = 0; $i < count($criteria); $i++) {
            $statement .= $criteria[$i] . '=' . '?';
            if ($i < count($criteria) - 1) {
               $statement .= ' AND ';
            }
         }
      }
      $statement .= ';';
      $this->db->query($statement);
      if (!empty($criteria) && !empty($criteriaVals)) {
         for ($i = 1; $i <= count($criteriaVals); $i++) {
            $this->db->bind($i, $criteriaVals[$i - 1]);
         }
      }
      return $this->db->execute();
   }

}
