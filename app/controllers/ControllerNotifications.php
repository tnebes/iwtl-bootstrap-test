<?php

declare(strict_types=1);

class ControllerNotifications extends Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {
      (new ControllerErrorPages)->restricted();
   }

   public function message(): void
   {
      $message = filter_var(trim(func_get_arg(0)), FILTER_SANITIZE_STRING);
      $this->view->render('notifications/message', ['message' => $message]);
   }
}
