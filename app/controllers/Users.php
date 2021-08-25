<?php declare(strict_types = 1);

   Class Users extends Controller
   {
      public function __construct()
      {
         $this->model = $this->getModel('User');
      }

      public function index() : void
      {
         if (!isLoggedIn())
         {
            header('location: error/error/restricted');
            return;
         }
         $data = [];
         if (isAdmin())
         {
            $users = $this->model->getUsersPrivate();
            $data['users'] = $users;
         }
         else
         {
            $users = $this->model->getUsersPublic();
            $data['users'] = $users;
         }
         $this->view('users/index', $data);
      }

      public function login() : void
      {
         if (isLoggedIn())
         {
            $this->view('pages/index');
            return;
         }
         $data = 
         [
            'email' => '',
            'password' => '',
            'loginError' => ''
         ];
         if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data['email'] = strtolower(trim($_POST['email']));
            $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $data['password'] = trim($_POST['password']);
            unset($_POST['email']);
            unset($_POST['password']);

            if (empty($data['email']))
            {
               $data['loginError'] .= 'Email is required. ';
            }
            else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            {
               $data['loginError'] .= 'A valid email is required. ';
            }   
            if (empty($data['password']))
            {
               $data['loginError'] .= 'Password is required. ';
            }

            if (empty($data['loginError']))
            {
               $user = $this->model->login($data['email'], $data['password']);
               if (!empty($user))
               {
                  createUserSession($user);
                  $this->view('pages/index');
                  return;
               }
               else
               {
                  $data['loginError'] .= 'Invalid email or password.';
               }
            }
         }

         $this->view('users/login', $data);
         return;
      }

      public function register() : void
      {
         if (isLoggedIn())
         {
            $this->view('pages/index');
            return;
         }
         $data =
         [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'confirmPasswordError' => ''
         ];
         if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data['username'] = strtolower(trim($_POST['username']));
            $data['email'] = strtolower(trim($_POST['email']));
            $data['password'] = trim($_POST['password']);
            $data['confirmPassword'] = trim($_POST['confirmPassword']);
            unset($_POST['username']);
            unset($_POST['email']);
            unset($_POST['password']);
            unset($_POST['confirmPassword']);
            
            $data['usernameError'] = validateUsername($data['username']);
            $data['emailError'] = validateEmail($data['email']);
            $data['passwordError'] = validatePassword($data['password']);
            $data['confirmPasswordError'] = validateConfirmPassword($data['password'], $data['confirmPassword']);

            if($this->model->userByUsernameExists($data['username']) || $this->model->userByEmailExists($data['email']))
            {
               $data['usernameError'] .= ' or email already taken.';
            }

            if (empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError']))
            {
               $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
               $user = $this->model->register($data['username'], $data['email'], $data['password']);
               if ($user)
               {
                  $this->view('users/login');
                  return;
               }
               else
               {
                  $data['usernameError'] .= ' is already taken. ';
               }
            }
         }
         $this->view('/users/register', $data);
      }

      public function profile() : void
      {
         if (!isLoggedIn())
         {
            header('location: /errorpages/restricted');
            return;
         }

         $id = func_get_args();
         if (empty($id))
         {
            $id = $_SESSION['id'];
         }
         else // TODO: terrible way of doing this
         {
            $id = $id[0];
         }
         $user = $this->model->getUserById((int) $id);
         if (empty($user))
         {
            header('location: error/notFound');
            return;
         }
         $this->view('users/profile', [$user]);
      }

      public function update() : void
      {
         if (!isLoggedIn())
         {
            header('location: /errorpages/restricted');
            return;
         }
         $id = func_get_args();
         if (empty($id))
         {
            header('location: /errorpages/internalError');
            return;
         }
         $id = (int) $id[0];
         $data =
         [
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'registrationDateError' => '',
            'roleError' => '',
            'lastLoginError' => '',
            'dateBannedError' => ''
         ];
         $user = $this->model->getUserById($id);
         if (empty($user))
         {
            header('location: /errorpages/notFound');
            return;
         }

         if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            $passwordChange = false;
            $registrationDateChange = false;
            $lastLoginChange = false;
            $dateBannedChange = false;

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data['username'] = strtolower(trim($_POST['username']));
            $data['email'] = strtolower(trim($_POST['email']));
            $data['password'] = trim($_POST['password']);
            $data['registrationDate'] = trim($_POST['registrationDate']);
            $data['role'] = trim($_POST['role']);
            $data['lastLogin'] = trim($_POST['lastLogin']);
            $data['banned'] = isset($_POST['banned']) ? 1 : 0; // TODO: bad workaround for when banned doesn't exist
            $data['dateBanned'] = trim($_POST['dateBanned']);

            unset($_POST['username']);
            unset($_POST['email']);
            unset($_POST['password']);
            unset($_POST['registrationDate']);
            unset($_POST['role']);
            unset($_POST['lastLogin']);
            unset($_POST['dateBanned']);
            unset($_POST['banned']);

            // case when the user wishes to change the password
            if (!empty($data['password']))
            {
               $passwordChange = true;
            }
            if (!empty($data['registrationDate']))
            {
               $registrationDateChange = true;
            }
            if (!empty($data['lastLogin']))
            {
               $lastLoginChange = true;
            }
            if (!empty($data['dateBanned']))
            {
               $dateBannedChange = true;
            }
            
            $data['usernameError'] = validateUsername($data['username']);
            if (checkDuplicateUsername($data['username'], $this->model) && $data['username'] !== strtolower($user->username))
            {
               $data['usernameError'] .= ' is already taken. ';
            }

            $data['emailError'] = validateEmail($data['email']);
            if (checkDuplicateEmail($data['email'], $this->model) && $data['email'] !== strtolower($user->email))
            {
               $data['emailError'] .= ' is already taken. ';
            }

            // if the user wishes to change the password
            if ($passwordChange)
            {
               $data['passwordError'] = validatePassword($data['password']);
            }            
            $data['registrationDateError'] = validateDate($data['registrationDate']);
            $data['roleError'] = validateRole($data['role']);
            $data['lastLoginError'] = validateDate($data['lastLogin']);
            $data['dateBannedError'] = validateDate($data['dateBanned']);
            
            if (empty($data['usernameError'])
            && empty($data['emailError'])
            && empty($data['passwordError'])
            && empty($data['registrationDateError'])
            && empty($data['roleError'])
            && empty($data['lastLoginError'])
            && empty($data['dateBannedError']))
            {
               $updatedUser = clone $user;

               if ($passwordChange)
               {
                  $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                  $updatedUser->password = $data['password'];
               }
               if ($registrationDateChange)
               {
                  $updatedUser->registrationDate = $data['registrationDate'];
               }
               if ($lastLoginChange)
               {
                  $updatedUser->lastLogin = $data['lastLogin'];
               }
               if ($dateBannedChange)
               {
                  $updatedUser->dateBanned = $data['dateBanned'];
               }

               $updatedUser->username = $data['username'];
               $updatedUser->email = $data['email'];
               $updatedUser->role = $data['role'];
               $updatedUser->banned = $data['banned'];

               $this->model->updateUser($updatedUser);
               header('location: /users/profile/' . $updatedUser->id);
               return;
            }
         }
         $this->view('users/update', [$user, $data]);
      }

      public function delete() : void
      {
         if (!isLoggedIn())
         {
            header('location: /errorpages/restricted');
            return;
         }
         $id = func_get_args();
         if (empty($id))
         {
            header('location: /errorpages/internalError');
            return;
         }
         $id = (int) $id[0];
         $user = $this->model->getUserById((int) $id);
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

         if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if (isset($_POST['confirm']) && filter_var($_POST['confirm'], FILTER_VALIDATE_BOOLEAN))
            {
               $this->model->deleteUserById($id);
               $this->index();
               return;
            }
            /// TODO: this should be a proper redirect.
            $this->index();
            return;
         }
         $this->view('users/delete', [$user]);
      }

      public function ban() : void
      {
         if (!isLoggedIn())
         {
            header('location: /errorpages/restricted');
            return;
         }
         $id = func_get_args();
         if (empty($id))
         {
            header('location: /errorpages/internalError');
            return;
         }
         $id = (int) $id[0];
         $user = $this->model->getUserById((int) $id);
         if (empty($user))
         {
            header('location: /errorpages/internalError');
            return;
         }
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && filter_var($_POST['confirm'], FILTER_VALIDATE_BOOLEAN))
         {
            $user->banned = $user->banned ? 0 : 1;
            $user->dateBanned = date('Y-m-d H:i:s');
            $this->model->updateUser($user);
            header('location: /users/profile/' . $user->id);
            return;
         }
         $this->view('users/ban', [$user]);
      }

      public function logout() : void
      {
         clearUserSession();
         $this->view('/pages/index');
      }
   }