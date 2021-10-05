<?php

declare(strict_types=1);

class UserTopicSubscription extends Model
{
   public function __construct()
   {
      parent::__construct();
      $this->TABLE_NAME = 'usertopicsubscription';
   }

}