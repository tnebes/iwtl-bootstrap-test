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

   public function getUsers(string $data, int $from, int $to): array
   {
      $sql = "select $data from $this->TABLE_NAME limit :from, :to;";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':from', $from, PDO::PARAM_INT);
      $statement->bindParam(':to', $to, PDO::PARAM_INT);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_OBJ);
   }

   public function userByEmailExists(string $email): bool
   {
      return (bool)$this->readSingle($this->TABLE_NAME, ['*'], ['email'], [$email]);
   }

   public function userByUsernameExists(string $username): bool
   {
      return (bool)$this->readSingle($this->TABLE_NAME, ['*'], ['username'], [$username]);
   }

   public function getUserById(int $id): ?stdClass
   {
      $user = $this->read($this->TABLE_NAME, ['*'], ['id'], [$id]);
      return $user ? $user[0] : null;
   }

   public function deleteUserById(int $id): bool
   {
      return $this->delete($this->TABLE_NAME, ['id'], [$id]);
   }

   public function updateUser(stdClass $user): bool
   {
      $user = (array) $user;
      $userId = (int) $user['id'];
      unset($user['id']); // cursed: to prevent the id from being updated
      $userCols = array_keys($user);
      return $this->update($this->TABLE_NAME, $userCols, $user, ['id'], [$userId]);
   }

   public function updateUserLogin(int $userId, string $time): bool
   {
      $sql = "UPDATE $this->TABLE_NAME SET lastLogin = :time WHERE id = :id";
      $statement = $this->dbHandler->prepare($sql);
      $statement->bindParam(':time', $time);
      $statement->bindParam(':id', $userId, PDO::PARAM_INT);
      return $statement->execute();
   }

   public function getIsAdmin(string $id): bool
   {
      return $this->read($this->TABLE_NAME, ['role'], ['id'], [$id])[0]->role == ADMIN_ROLE;
   }
}
