<?php declare(strict_types = 1);

   Class User
   {
      private $db;

      public function __construct()
      {
         $this->db = new Database();
      }

   }