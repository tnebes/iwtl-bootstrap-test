<?php

declare(strict_types=1);

class ControllerPages extends Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   /**
    *
    */
   public function index(): void
   {
      $this->view->render('pages/index');
   }

   /**
    *
    */
   public function about(): void
   {
      header('location: https://www.github.com/tnebes');
   }

   public function debug() : void
   {
      $faker = Faker\Factory::create();
      $NUM_OF_USER_TOPICS = 100;
      // create 100 users, 100 topics for each user, 1 review per topic
      for ($i = 0; $i < $NUM_OF_USER_TOPICS; $i++)
      {
         (new User)->register($faker->userName(), $faker->email(), $faker->password());
      }
      for ($i = 0; $i < $NUM_OF_USER_TOPICS; $i++)
      {
         (new Topic)->createTopic($faker->jobTitle(), $faker->realTextBetween(), (new DateTime())->format('Y-m-d H:i:s'), random_int(1, 100));
      }
      
      
      echo 'inserted users.';
   }
}
