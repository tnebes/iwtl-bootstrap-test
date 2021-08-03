<?php declare(strict_types = 1); 

abstract Class Model
{
   protected $db;

   public function __construct()
   {
      $this->db = new Database();
   }

   /**
    * Protected create function.
    * @param tname is the table name in the SQL database
    * @param cols is the column(s) to be created
    * @param vals is the values to be inserted into the columns
    */
   protected function create(string $tName, array $cols, array $vals) : bool
   {
      // TODO: proper exception required.
      if (empty($tName))
      {
         die('Table name not defined.');
      }

      if (count($cols) != count($vals))
      {
         die('Too few arguments for creation');
      }
      //

      $statement = 'INSERT INTO ';
      $statement .= $tName;
      $statement .= ' (';
      for ($i = 0; $i < count($cols); $i++)
      {
         $statement .= $cols[$i];
         if ($i < count($cols) - 1)
         {
            $statement .= ',';
         }
      }
      $statement .= ') ';
      $statement .= 'VALUES (';
      for ($i = 0; $i < count($vals); $i++)
      {
         $statement .= '?';
         if ($i < count($vals) - 1)
         {
            $statement .= ',';
         }
      }
      $statement .= ');';
      $this->db->query($statement);
      for ($i = 1; $i <= count($vals); $i++)
      {
         $this->db->bind($i, $vals[$i - 1]);
      }
      return $this->db->execute();
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