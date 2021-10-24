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
      // create 100 users, 100 topics, 1 review per topic
      $userModel = new User;
      $topicModel = new Topic;
      $userModel->register('tnebes', 't@nebes.hr', password_hash('letmeinside1', PASSWORD_DEFAULT));
      $userModel->register('normie', 'normal@person.com', password_hash('letmeinside1', PASSWORD_DEFAULT));
      for ($i = 0; $i < $NUM_OF_USER_TOPICS; $i++)
      {
         $userModel->register($faker->userName(), $faker->email(), password_hash($faker->password(), PASSWORD_DEFAULT));
      }
      for ($i = 0; $i < $NUM_OF_USER_TOPICS; $i++)
      {
         $topicModel->createTopic($faker->jobTitle(), $faker->realTextBetween(), (new DateTime())->format('Y-m-d H:i:s'), random_int(1, 50), null);
      }
      
      
      echo 'inserted users.';
   }
}
