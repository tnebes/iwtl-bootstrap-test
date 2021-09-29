<?php

declare(strict_types=1);

class User extends Model
{
   public function __construct()
   {
      parent::__construct();
      $this->TABLE_NAME = 'user';
   }

   public function login(string $email, string $password): ?stdClass
   {
      $user = $this->readSingle(
         $this->TABLE_NAME,
         ['*'],
         ['email'],
         [$email]
      );
      if (!$user) {
         return null;
      }
      if ($user->banned) {
         return null;
      }
      $hashedPassword = $user->password;
      return password_verify($password, $hashedPassword) ? $user : null;
   }

   public function register(string $username, string $email, string $password): bool
   {
      return $this->create(
         $this->TABLE_NAME,
         ['username', 'password', 'email'],
         [$username, $password, $email]
      );
   }

   public function getUsersPrivate(): array
   {
      return $this->read($this->TABLE_NAME, [PRIVATE_SQL_DATA], null, null);
   }

   public function getUsersPublic(): array
   {
      return $this->read($this->TABLE_NAME, [PUBLIC_SQL_DATA], null, null);
   }

   public function userByEmailExists(string $email): bool
   {
      return $this->readSingle($this->TABLE_NAME, ['*'], ['email'], [$email]) ? true : false;
   }

   public function userByUsernameExists(string $username): bool
   {
      return $this->readSingle($this->TABLE_NAME, ['*'], ['username'], [$username]) ? true : false;
   }

   public function getUserById(int $id): ?stdClass
   {
      $user = $this->read($this->TABLE_NAME, ['*'], ['id'], [$id]);
      return $user ? $user[0] : null;
   }

   public function banUserById(int $id): bool
   {
      // TODO: ban and unban methods.
      return true;
   }

   public function unbanUserById(int $id): bool
   {
      return true;
   }

   public function deleteUserById(int $id): bool
   {
      // TODO: implement an admin check so that admins cannot be deleted by using getIsAdmin();
      return $this->delete($this->TABLE_NAME, ['id'], [$id]);
   }

   public function updateUser(stdClass $user): bool
   {
      $user = (array) $user;
      $userId = (int) $user['id'];
      unset($user['id']); // to prevent the id from being updated
      // TODO: this is broken.
      return $this->update($this->TABLE_NAME, $user, ['id'], [$userId]);
   }

   public function getIsAdmin(string $id): bool
   {
      return $this->read($this->TABLE_NAME, ['role'], ['id'], [$id])[0]->role == ADMIN_ROLE;
   }
}
