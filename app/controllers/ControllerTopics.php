<?php declare(strict_types = 1);

   class ControllerTopics extends Controller
   {
      public function __construct()
      {
         parent::__construct();
         $this->model = $this->getModel('Topic');
      }

      public function index() : void
      {
         $topics = $this->model->getTopics();
         $this->view->render('topics/index', ['topics' => $topics]);
      }

      public function topic() : void
      {
         $this->view->render('topics/topic');
      }

      public function create() : void
      {
         $this->view->render('topics/create');
      }

      public function edit() : void
      {
         $this->view->render('topics/edit');
      }

      public function delete() : void
      {
         $this->view->render('topics/delete');
      }
   }