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
               if ($user)
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
         
      }

      public function logout() : void
      {
         clearUserSession();
         $this->view('/pages/index');
      }
   }