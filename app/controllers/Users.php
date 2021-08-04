<?php declare(strict_types = 1);

   Class Users extends Controller
   {
      public function __construct()
      {
         $this->model = $this->getModel('User');
      }

      public function index() : void
      {
         $this->view('users/index');
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
            $data['email'] = trim($_POST['email']);
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
            $data['username'] = trim($_POST['username']);
            $data['email'] = trim($_POST['email']);
            $data['password'] = trim($_POST['password']);
            $data['confirmPassword'] = trim($_POST['confirmPassword']);
            unset($_POST['username']);
            unset($_POST['email']);
            unset($_POST['password']);
            unset($_POST['confirmPassword']);
            
            if (empty($data['username']))
            {
               $data['usernameError'] .= 'Username is required. ';
            }
            else if (strlen($data['username']) < 3)
            {
               $data['usernameError'] .= 'Username must be at least 3 characters long. ';
            }
            else if (strlen($data['username']) > 20)
            {
               $data['usernameError'] .= 'Username must be no more than 20 characters long. ';
            }
            else if (!ctype_alnum($data['username']))
            {
               $data['usernameError'] .= 'Username must be alphanumeric. ';
            }

            if (empty($data['email']))
            {
               $data['emailError'] .= 'Email is required. ';
            }
            else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            {
               $data['emailError'] .= 'A valid email is required. ';
            }

            if (empty($data['password']))
            {
               $data['passwordError'] .= 'Password is required. ';
            }
            else if (strlen($data['password']) < 6)
            {
               $data['passwordError'] .= 'Password must be at least 6 characters long. ';
            }
            else if (strlen($data['password']) > 20)
            {
               $data['passwordError'] .= 'Password must be no more than 20 characters long. ';
            }

            if ($data['password'] !== $data['confirmPassword'])
            {
               $data['confirmPasswordError'] .= 'Passwords do not match. ';
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
                  $data['usernameError'] .= 'Username is already taken. ';
               }
            }
         }
         $this->view('/users/register', $data);
      }

      public function logout() : void
      {
         clearUserSession();
         $this->view('/pages/index');
      }
   }