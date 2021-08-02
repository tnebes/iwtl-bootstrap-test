<?php declare(strict_types = 1); 

abstract Class Model
{
   protected $data;

   public function __construct()
   {
      $this->data = [];
   }

   private function query(string $tableName, array $columnNames, array $values, array $criteria,  array $criteriaValues) : array
   {
      define('TABLE_NAME', 0);
      define('CONDITIONS_VALUES', 1);
      define('CRITERIA_VALUES', 2);

      // edge case for select and other possible SQL queries.
      if (count($values) != 0 && (count($columnNames) != count($values)))
      {
         die('You have entered too few values into SQL.');
      }
      if (count($criteriaValues) != 0 && (count($criteria) != count($criteriaValues)))
      {
         die('You have entered too few criteria values into SQL.');
      }

      $statement = [];
      $statement[TABLE_NAME] = $tableName;
      $statement[CONDITIONS_VALUES] = [];
      if (count($columnNames) == 1 && $columnNames[0] == '*')
      {
         $statement[CONDITIONS_VALUES][0] = '*';
      }
      else
      {
         for ($i = 0; $i < count($columnNames) - 1; $i++)
         {
            $phrase = '';
            $phrase .= "$columnNames[$i]";
            if (!($i > count($values)))
            {
               $phrase .= "=$values[$i]";
            }
            // TODO: this is not efficient
            if ($i == count($columnNames) - 2)
            {
               $statement[CONDITIONS_VALUES][$i] = $phrase;
            }
            else
            {
               $phrase = ',';
               $statement[CONDITIONS_VALUES][$i] = $phrase;
            }
         }
      }

      $statement[CRITERIA_VALUES] = [];
      if (count($criteria) == 1 && $criteria[0] == '*')
      {
         $statement[CONDITIONS_VALUES][0] = '*';
      }
      else
      {
         for ($i = 0; $i < count($criteria) - 1; $i++)
         {
            $phrase = '';
            $phrase .= "$criteria[$i]";
            if (!($i > count($criteriaValues)))
            {
               $phrase .= "=$criteriaValues[$i]";
            }
            // TODO: this is not efficient
            if ($i == count($criteria) - 2)
            {
               $statement[CONDITIONS_VALUES][$i] = $phrase;
            }
            else
            {
               $phrase = ',';
               $statement[CONDITIONS_VALUES][$i] = $phrase;
            }
         }
      }






      return [];
   }

   protected function create() : bool
   {

      return true;
   }
   protected function read() : array
   {

      return [];
   }
   protected function update() : bool
   {

      return true;
   }
   protected function delete() : bool
   {

      return true;
   }
   

}