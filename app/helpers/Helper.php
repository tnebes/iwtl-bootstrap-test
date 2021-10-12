<?php

declare(strict_types=1);

class Helper
{
   private static $instance;

   private function __construct()
   {
      self::$instance = $this;
   }

   public static function getInstance(): Helper
   {
      if (!isset(self::$instance)) {
         self::$instance = new self();
      }
      return self::$instance;
   }

   public function debugDisplay($var): void
   {
      echo '<pre>';
      var_dump($var);
      echo '</pre>';
   }

   public function isLoggedIn(): bool
   {
      return isset($_SESSION['id']);
   }

   public function isAdmin(): bool
   {
      return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
   }

   public function createUserSession(stdClass $user): void
   {
      $_SESSION['id'] = $user->id;
      $_SESSION['username'] = $user->username;
      $_SESSION['admin'] = $user->role != 0;
   }

   public function clearUserSession(): void
   {
      unset($_SESSION['id']);
      unset($_SESSION['username']);
      unset($_SESSION['admin']);
   }

   function getLinkToTopic(stdClass $topic): string
   {
      return URL_ROOT . '/topics/topic/' . $topic->id;
   }

   function roleToString(int $role): string
   {
      $roles = ['user', 'admin'];
      return $roles[$role];
   }

   function bannedToCheckbox(int $banned, bool $disabled = false): string
   {
      return '<input class="form-check-input mx-auto" type="checkbox" name="banned" value="true" ' . ($disabled ? 'disabled' : '') . ' ' . ($banned ? 'checked' : '') . '>';
   }

   function validateUsername(string $username): string
   {
      if (empty($username)) {
         return ' is required. ';
      } else if (strlen($username) < 3) {
         return ' must be at least 3 characters long. ';
      } else if (strlen($username) > 20) {
         return ' must be no more than 20 characters long. ';
      } else if (!ctype_alnum($username)) {
         return ' must be alphanumeric. ';
      }
      return '';
   }

   function checkDuplicateUsername(string $username, User $userModel): string
   {
      if ($userModel->userByUsernameExists($username)) {
         return ' already taken. ';
      }
      return '';
   }

   function validateEmail(string $email): string
   {
      if (empty($email)) {
         return ' is required. ';
      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         return 'A valid email is required. ';
      }
      return '';
   }

   function checkDuplicateEmail(string $email, User $userModel): string
   {
      if ($userModel->userByEmailExists($email)) {
         return ' already taken. ';
      }
      return '';
   }

   function validatePassword(string $password): string
   {
      if (empty($password)) {
         return ' is required. ';
      } else if (strlen($password) < 6) {
         return ' must be at least 6 characters long. ';
      } else if (strlen($password) > 20) {
         return ' must be no more than 20 characters long. ';
      }
      return '';
   }

   function validateConfirmPassword(string $password, string $confirmPassword): string
   {
      if (empty($confirmPassword)) {
         return ' is required. ';
      } else if ($password !== $confirmPassword) {
         return ' must match the password. ';
      }
      return '';
   }

   function validateDate(string $date): string
   {
      echo $date . ' ';
      if (empty($date)) {
         return ' is required. ';
      } else if (!(preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $date))) {
         return ' must be in the format YYYY-MM-DD or YYYY-MM-DD HH:MM:SS';
      }
      return '';
   }

   function validateRole(string $role): string
   {
      return $role < 0 || $role > 1 ? ' must be a valid role. ' : '';
   }

   /*
   Topics
   */

   function getRandomTopicTitle(): string
   {
      $topicTitles =
         [
            'How to learn PHP OOP',
            'Where to learn Java inheritance',
            'How can I create MVC app',
            'How to use databases?',
            'How does an PHP autoloader work?'
         ];
      return $topicTitles[array_rand($topicTitles)];
   }

   function getUserFromTopic(stdClass $topic): ?stdClass
   {
      $m = new User();
      return $m->getUserById((int) $topic->user);
   }

   function getLinkToUser(stdClass $user): string
   {
      return URL_ROOT . '/users/profile/' . $user->id;
   }
}
