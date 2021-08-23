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
            
            if (empty($data['username']))
            {
               $data['usernameError'] .= ' is required. ';
            }
            else if (strlen($data['username']) < 3)
            {
               $data['usernameError'] .= ' must be at least 3 characters long. ';
            }
            else if (strlen($data['username']) > 20)
            {
               $data['usernameError'] .= ' must be no more than 20 characters long. ';
            }
            else if (!ctype_alnum($data['username']))
            {
               $data['usernameError'] .= ' must be alphanumeric. ';
            }

            if (empty($data['email']))
            {
               $data['emailError'] .= ' is required. ';
            }
            else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            {
               $data['emailError'] .= 'A valid email is required. ';
            }

            if (empty($data['password']))
            {
               $data['passwordError'] .= ' is required. ';
            }
            else if (strlen($data['password']) < 6)
            {
               $data['passwordError'] .= ' must be at least 6 characters long. ';
            }
            else if (strlen($data['password']) > 20)
            {
               $data['passwordError'] .= ' must be no more than 20 characters long. ';
            }

            if ($data['password'] !== $data['confirmPassword'])
            {
               $data['confirmPasswordError'] .= ' do not match. ';
            }
            else if (empty($data['confirmPassword']))
            {
               $data['confirmPasswordError'] .= ' is required. ';
            }

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
         }
         $this->view('users/delete', [$user]);
      }

      public function ban() : void
      {

      }

      public function logout() : void
      {
         clearUserSession();
         $this->view('/pages/index');
      }
   }