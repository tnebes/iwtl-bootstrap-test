<?php declare(strict_types = 1); 

abstract Class Model
{
   protected $db;
   protected $TABLE_NAME;

   public function __construct()
   {
      $this->db = new Database();
      if (empty($this->db))
      {
         die('Could not connect to database.');
      }
   }

   /**
    * Protected create function.
    * @return bool
    * @param tName is the table name in the SQL database
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

      if (empty($cols) || empty($vals))
      {
         die('No columns or values specified');
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

   /**
    * Protected read function
    * @return array
    * @param tName table name
    * @param cols affected columns
    * @param criteria where criteria
    * @param criteriaVals where criteria values
    * SELECT cols FROM tName WHERE criterion0 = criteriaVal0 OR criterion1 = criterionVal1...
    */
   protected function read(string $tName, array $cols, ?array $criteria, ?array $criteriaVals) : array
   {
      if (empty($tName))
      {
         die('Table name not defined.');
      }
      if (empty($cols))
      {
         die('Columns not defined.');
      }

      $statement = 'SELECT ';
      if (count($cols) === 1 && $cols[0] == '*')
      {
         $statement .= $cols[0] . ' ';
      }
      else
      {
         for ($i = 0; $i < count($cols); $i++)
         {
            $statement .= $cols[$i];
            if ($i < count($cols) - 1)
            {
               $statement .= ',';
            }   
         }
      }

      $statement .= 'FROM ';
      $statement .= $tName;
      if (!empty($criteria) && !empty($criteriaVals))
      {
         $statement .= ' WHERE ';
         for ($i = 0; $i < count($criteria); $i++)
         {
            $statement .= $criteria[$i] . '=' . '?';
            if ($i < count($cols) - 1)
            {
               $statement .= ' OR ';
            }   
         }
      }
      $statement .= ';';
      $this->db->query($statement);

      for ($i = 1; $i <= count($criteriaVals); $i++)
      {
         $this->db->bind($i, $criteriaVals[$i - 1]);
      }

      return $this->db->resultSet();
   }

   protected function readSingle(string $tName, array $cols, ?array $criteria, ?array $criteriaVals) : ?stdClass
   {
      $single = $this->read($tName, $cols, $criteria, $criteriaVals)[0];
      return $single ? $single : null;
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