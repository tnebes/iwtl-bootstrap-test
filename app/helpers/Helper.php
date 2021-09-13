<?php

declare(strict_types=1);

class Helper
{
   private static $instance;

   private function __construct()
   {
      $instance = $this;
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
      if ($this->isLoggedIn()) {
         $userModel = new User();
         return $userModel->getIsAdmin($_SESSION['id']);
      }
      return false;
   }

   public function createUserSession(stdClass $user): void
   {
      $_SESSION['id'] = $user->id;
      $_SESSION['username'] = $user->username;
   }

   public function clearUserSession(): void
   {
      unset($_SESSION['id']);
      unset($_SESSION['username']);
   }

   function getLinkToTopic(stdClass $topic): string
   {
      return URL_ROOT . '/topics/topic/' . $topic->id;
   }

   function getUserActionsAdmin(int $userId): string
   {
      $methods = ['profile', 'update', 'delete', 'ban'];
      $iconLocation = URL_ROOT . '/img/icons/';
      $icons = ['file-person.svg', 'wrench.svg', 'x-lg.svg', 'mic-mute.svg'];
      $returnString = '';
      for ($i = 0; $i < count($methods); $i++) {
         $returnString .= '<a href=' . URL_ROOT . '/users/' . $methods[$i] . '/' . $userId . '><img data-toggle="tooltip" data-placement="bottom" title="' . $methods[$i] . '" width=20px src="' . $iconLocation . $icons[$i] . '" alt="' . $methods[$i] . '" /></a> ';
      }
      return $returnString;
   }

   function getUserActions(int $userId): string
   {
      $methods = ['profile'];
      $iconLocation = URL_ROOT . '/img/icons/';
      $icons = ['file-person.svg'];
      $returnString = '';
      for ($i = 0; $i < count($methods); $i++) {
         $returnString .= '<a href=' . URL_ROOT . '/users/' . $methods[$i] . '/' . $userId . '><img data-toggle="tooltip" data-placement="bottom" title="' . $methods[$i] . '" width=20px src="' . $iconLocation . $icons[$i] . '" alt="' . $methods[$i] . '" /></a> ';
      }
      return $returnString;
   }

   function roleToString(int $role): string
   {
      $roles = ['user', 'admin'];
      return $roles[$role];
   }

   function bannedToString(int $banned): string
   {
      return $banned ? 'yes' : 'no';
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
      // TODO: add validation here.
      return '';
   }

   function validateRole(string $role): string
   {
      // TODO: update this if new roles are added.
      return $role < 0 || $role > 1 ? ' must be a valid role. ' : '';
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
