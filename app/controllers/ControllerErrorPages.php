<?php

declare(strict_types=1);

class ControllerErrorPages extends Controller
{
   public function __construct()
   {
      parent::__construct();
   }

    /**
     *
     */
    public function notFound(): void
   {
      $this->view->render('error' . DIRECTORY_SEPARATOR . 'error', ['title' => 'Page not found.', 'description' => "The page you're looking for doesn't exist."]);
   }

    /**
     *
     */
    public function restricted(): void
   {
      $this->view->render('error' . DIRECTORY_SEPARATOR . 'error', ['title' => 'You are not allowed to do this.', 'description' => "You don't have the permission to do this."]);
   }

    /**
     *
     */
    public function notImplemented(): void
   {
      $this->view->render('error' . DIRECTORY_SEPARATOR . 'error', ['title' => 'Work in progress. Check back later.', 'description' => "This feature is not implemented yet."]);
   }

    /**
     *
     */
    public function internalError(): void
   {
      $this->view->render('error' . DIRECTORY_SEPARATOR . 'error', ['title' => 'Internal server error.', 'description' => "Something went wrong on our side."]);
   }
}
