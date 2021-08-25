<?php declare(strict_types = 1);

   class Topics extends Controller
   {
      public function __construct()
      {
         $this->model = $this->getModel('Topic');
      }

      public function index() : void
      {
         $this->view('topics/index');
      }

      public function topic() : void
      {
         $this->view('topics/topic');
      }

      public function create() : void
      {
         $this->view('topics/create');
      }

      public function edit() : void
      {
         $this->view('topics/edit');
      }

      public function delete() : void
      {
         $this->view('topics/delete');
      }
   }