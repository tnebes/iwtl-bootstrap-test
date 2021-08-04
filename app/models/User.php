<?php declare(strict_types = 1);

   Class User extends Model
   {
      protected $TABLE_NAME;

      public function __construct()
      {
         parent::__construct();
         $this->TABLE_NAME = 'user';
      }

      public function login(string $email, string $password) : ?stdClass
      {
         $user = $this->readSingle(
            $this->TABLE_NAME,
            ['*'],
            ['email'],
            [$email]
         );
         if (!$user)
         {
            return null;
         }
         if ($user->banned)
         {
            return null;
         }
         $hashedPassword = $user->password;
         return password_verify($password, $hashedPassword) ? $user : null;
      }

      public function register(string $username, string $email, string $password) : bool
      {
         return $this->create($this->TABLE_NAME,
            ['username', 'password', 'email'],
            [$username, $password, $email]
         );
      }

      public function getUsersPrivate() : array
      {
         return [];
      }

      public function getUsersPublic() : array
      {
         return [];
      }

      public function userByEmailExists(string $email) : bool
      {
         return $this->readSingle($this->TABLE_NAME, ['*'], ['email'], [$email]) ? true : false;
      }

      public function userByUsernameExists(string $username) : bool
      {
         return $this->readSingle($this->TABLE_NAME, ['*'], ['username'], [$username]) ? true : false;
      }

      public function getUsersById(array $id) : array
      {
         return [];
      }

      public function getUserById(string $id) : ?stdClass
      {
         return null;
      }

      public function banUserById(string $id) : bool
      {
         return true;
      }

      public function unbanUserById(string $id) : bool
      {
         return true;
      }

      public function deleteUserById(string $id) : bool
      {
         return true;
      }

      public function updateUser(stdClass $user) : ?stdClass
      {
         return null;
      }

      public function getIsAdmin(string $id) : bool
      {
         // TODO: bad and messy.
         return $this->read($this->TABLE_NAME, ['role'], ['id'], [$id])[0]->role == ADMIN_ROLE;
      }



   }