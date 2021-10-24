<?php

declare(strict_types=1);

class Pagination extends Controller
{
   protected $numberOfEntries;
   protected $numberOfPages;
   protected $currentPage;
   protected $tableName;

   public function __construct()
   {
      parent::__construct();
   }

   protected function getEntries(): ?int
   {
      return (new ModelPagination)->getEntries($this->tableName);
   }
}
