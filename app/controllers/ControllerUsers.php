<?php

declare(strict_types=1);

class ControllerUsers extends Pagination
{
   public function __construct()
   {
      parent::__construct();
      $this->model = $this->getModel('User');
      $this->tableName = 'user';
   }

   /**
    * Method handles the sending of data to view.
    */
   public function index(): void
   {
      if (!$this->helper->isLoggedIn()) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }
      $this->currentPage = func_get_arg(0) ?? 1;
      $this->numberOfEntries = $this->getEntries();
      $this->numberOfPages = ceil($this->numberOfEntries / ENTRIES_PER_PAGE);
      if ($this->currentPage > $this->numberOfPages) {
         $this->currentPage = $this->numberOfPages;
      } else if ($this->currentPage < 1) {
         $this->currentPage = 1;
      }

      $users = [];
      if ($this->currentPage != 0)
      {
         if ($this->helper->isLoggedIn()) {
            $users = $this->model->getUsers(PRIVATE_SQL_DATA, (int) (ENTRIES_PER_PAGE * ($this->currentPage - 1)), (int) (ENTRIES_PER_PAGE));
         } else {
            $users = $this->model->getUsers(PUBLIC_SQL_DATA, (int) (ENTRIES_PER_PAGE * ($this->currentPage - 1)), (int) (ENTRIES_PER_PAGE));
         }
      }

      $this->view->render('users/index', [
         'users' => $users,
         'numberOfPages' => $this->numberOfPages,
         'currentPage' => $this->currentPage,
         'link' => URL_ROOT . '/users/index/'
      ]);
   }

   /**
    * Method handles the logging in of a user.
    */
   public function login(): void
   {
      if ($this->helper->isLoggedIn()) {
         header('location: ' . URL_ROOT . '/users/index');
         return;
      }

      $this->view = new View('formTemplate');

      $data =
         [
            'email' => '',
            'password' => '',
            'loginError' => ''
         ];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $data['email'] = strtolower(trim($_POST['email']));
         $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
         $data['password'] = trim($_POST['password']);
         unset($_POST['email']);
         unset($_POST['password']);

         if (empty($data['email'])) {
            $data['loginError'] .= 'Email is required. ';
         } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['loginError'] .= 'A valid email is required. ';
         }
         if (empty($data['password'])) {
            $data['loginError'] .= 'Password is required. ';
         }

         if (empty($data['loginError'])) {
            $user = $this->model->login($data['email'], $data['password']);
            if (!empty($user)) {
               if ($user->banned == 1) {
                  $data['loginError'] .= 'You cannot login as you have been banned.';
                  $data['password'] = '';
               } else {
                  $this->helper->createUserSession($user);
                  $this->model->updateUserLogin((int) $user->id, (new DateTime())->format('Y-m-d H:i:s'));
                  header('Location: ' . URL_ROOT . '/topics/index');
                  return;
               }
            } else {
               $data['loginError'] .= 'Invalid email or password.';
               $data['password'] = '';
            }
         }
      }

      $this->view->render('users/login', $data);
   }

   /**
    * Method handles the registration of a user.
    */
   public function register(): void
   {
      if ($this->helper->isLoggedIn() && !$this->helper->isAdmin()) {
         header('location: ' . URL_ROOT . '/users/index');
         return;
      }

      $this->view = new View('formTemplate');

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
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $data['username'] = strtolower(trim($_POST['username']));
         $data['email'] = strtolower(trim($_POST['email']));
         $data['password'] = trim($_POST['password']);
         $data['confirmPassword'] = trim($_POST['confirmPassword']);
         unset($_POST['username']);
         unset($_POST['email']);
         unset($_POST['password']);
         unset($_POST['confirmPassword']);

         $data['usernameError'] = $this->helper->validateUsername($data['username']);
         $data['emailError'] = $this->helper->validateEmail($data['email']);
         $data['passwordError'] = $this->helper->validatePassword($data['password']);
         $data['confirmPasswordError'] = $this->helper->validateConfirmPassword($data['password'], $data['confirmPassword']);
         if ($data['passwordError'] || $data['confirmPasswordError']) {
            $data['password'] = '';
            $data['confirmPassword'] = '';
         }
         if ($this->model->userByUsernameExists($data['username']) || $this->model->userByEmailExists($data['email'])) {
            $data['usernameError'] .= ' or email already taken.';
         }

         if (empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $user = $this->model->register($data['username'], $data['email'], $data['password']);
            if ($user) {
               $this->view->render('users/login');
               return;
            } else {
               $data['usernameError'] .= ' is already taken. ';
            }
         }
      }
      $this->view->render('/users/register', $data);
   }

   /**
    * Method handles the showing of a user profile.
    */
   public function profile(): void
   {
      if (!$this->helper->isLoggedIn()) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }

      $id = func_get_args();
      if (empty($id)) {
         $id = $_SESSION['id'];
      } else // TODO: terrible way of doing this
      {
         $id = $id[0];
      }
      $user = $this->model->getUserById((int) $id);
      if (empty($user)) {
         header('location: ' . URL_ROOT . '/errorPages/notFound');
         return;
      }
      $this->view->render('users/profile', ['user' => $user]);
   }

   /**
    * Method handles the update of an user based on the user id.
    */
   public function update(): void
   {
      if (!$this->helper->isLoggedIn()) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }
      $id = func_get_args();
      if (empty($id)) {
         header('location: ' . URL_ROOT . '/errorPages/internalError');
         return;
      }
      $id = (int) $id[0];
      if (!$this->helper->isAdmin() && $_SESSION['id'] != $id) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }
      $data =
         [
            'redirect' => $_POST['redirect'] ?? $_SERVER['HTTP_REFERER'] ?? URL_ROOT,
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'registrationDateError' => '',
            'roleError' => '',
            'lastLoginError' => '',
            'dateBannedError' => ''
         ];
      $user = $this->model->getUserById($id);
      if (empty($user)) {
         header('location: ' . URL_ROOT . '/errorPages/notFound');
         return;
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $updatedUser = clone $user;
         $passwordChange = false;
         $registrationDateChange = false;
         $lastLoginChange = false;
         $dateBannedChange = false;

         // extremely cursed way of doing this
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $data['username'] = strtolower(trim($_POST['username']));
         $data['email'] = strtolower(trim($_POST['email']));
         $data['password'] = trim($_POST['password']);
         $data['registrationDate'] = trim($_POST['registrationDate'] ?? $user->registrationDate);
         $data['role'] = trim($_POST['role']?? $user->role);
         $data['lastLogin'] = trim($_POST['lastLogin'] ?? $user->lastLogin);
         $data['banned'] = (isset($_POST['banned']) ? 1 : 0 ?? $user->banned); // TODO: bad workaround for when banned doesn't exist
         $data['dateBanned'] = trim($_POST['dateBanned'] ?? $user->dateBanned);

         unset($_POST['username']);
         unset($_POST['email']);
         unset($_POST['password']);
         unset($_POST['registrationDate']);
         unset($_POST['role']);
         unset($_POST['lastLogin']);
         unset($_POST['dateBanned']);
         unset($_POST['banned']);

         // case when the user wishes to change the password
         if (!empty($data['password'])) {
            $passwordChange = true;
         }
         if (!empty($data['registrationDate'])) {
            $registrationDateChange = true;
         }
         if (!empty($data['lastLogin'])) {
            $lastLoginChange = true;
         }
         if (!empty($data['dateBanned'])) {
            $dateBannedChange = true;
         }

         $data['usernameError'] = $this->helper->validateUsername($data['username']);
         if ($this->helper->checkDuplicateUsername($data['username'], $this->model) && $data['username'] !== strtolower($user->username)) {
            $data['usernameError'] .= ' is already taken. ';
         }

         $data['emailError'] = $this->helper->validateEmail($data['email']);
         if ($this->helper->checkDuplicateEmail($data['email'], $this->model) && $data['email'] !== strtolower($user->email)) {
            $data['emailError'] .= ' is already taken. ';
         }

         // if the user wishes to change the password
         if ($passwordChange) {
            $data['passwordError'] = $this->helper->validatePassword($data['password']);
         }
         $data['registrationDateError'] = $this->helper->validateDate($data['registrationDate']);
         $data['roleError'] = $this->helper->validateRole($data['role']);
         $data['lastLoginError'] = $this->helper->validateDate($data['lastLogin']);
         $data['dateBannedError'] = $this->helper->validateDate($data['dateBanned']);

         if (
            empty($data['usernameError'])
            && empty($data['emailError'])
            && empty($data['passwordError'])
            && empty($data['registrationDateError'])
            && empty($data['roleError'])
            && empty($data['lastLoginError'])
            && empty($data['dateBannedError'])
         ) {

            if ($passwordChange) {
               $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
               $updatedUser->password = $data['password'];
            }
            if ($registrationDateChange) {
               $updatedUser->registrationDate = $data['registrationDate'];
            }
            if ($lastLoginChange) {
               $updatedUser->lastLogin = $data['lastLogin'];
            }
            if ($dateBannedChange) {
               $updatedUser->dateBanned = $data['dateBanned'];
            }

            $updatedUser->username = $data['username'];
            $updatedUser->email = $data['email'];
            $updatedUser->role = $data['role'];
            $updatedUser->banned = $data['banned'];

            $this->model->updateUser($updatedUser);

            header('location: ' . URL_ROOT . '/users/profile/' . $updatedUser->id);
            return;
         }
      }
      $this->view->render('users/update', ['user' => $user, 'data' => $data]);
   }

   /**
    * Method handles the deletion of a user.
    */
   public function delete(): void
   {
      if (!$this->helper->isLoggedIn()) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }
      $id = (int) func_get_args()[0];
      if (empty($id)) {
         header('location: ' . URL_ROOT . '/errorPages/internalError');
         return;
      }
      if (!($this->helper->isAdmin() || $_SESSION['id'] == $id)) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }
      $user = $this->model->getUserById($id);
      if (empty($user)) {
         header('location: ' . URL_ROOT . '/errorPages/internalError');
         return;
      }

      // cursed
      // check if the redirect exists
      if (!isset(func_get_args()[1]) && !isset($_POST['redirect'])) {
         // no redirect
         $redirect = $_SERVER['HTTP_REFERER'] ?? URL_ROOT . '/users/index';
      } elseif (isset($_POST['redirect'])) {
         // redirect exists
         $redirect = $_POST['redirect'];
      } else {
         $redirect = func_get_args()[1];
      }

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         if (isset($_POST['confirm']) && filter_var($_POST['confirm'], FILTER_VALIDATE_BOOLEAN)) {            
            $this->model->deleteUserById($id);
            if ($_SESSION['id'] == $id) {
               $this->logout();
            }
         }
         header('location: ' . $redirect);
         return;
      }
      $this->view->render('users/delete', ['user' => $user, 'redirect' => $redirect]);
   }

   /**
    * Method handles the banning of an user.
    */
   public function ban(): void
   {
      if (!$this->helper->isLoggedIn() || !$this->helper->isAdmin()) {
         header('location: ' . URL_ROOT . '/errorPages/restricted');
         return;
      }

      $id = (int) func_get_args()[0];
      if (empty($id)) {
         header('location: ' . URL_ROOT . '/errorPages/internalError');
         return;
      }

      $user = $this->model->getUserById($id);
      if (empty($user)) {
         header('location: ' . URL_ROOT . '/errorPages/internalError');
         return;
      }

      // cursed
      // check if the redirect exists
      if (!isset(func_get_args()[1]) && !isset($_POST['redirect'])) {
         // no redirect
         $redirect = $_SERVER['HTTP_REFERER'] ?? URL_ROOT . '/users/index';
      } elseif (isset($_POST['redirect'])) {
         // redirect exists
         $redirect = $_POST['redirect'];
      } else {
         $redirect = func_get_args()[1];
      }

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         if (isset($_POST['confirm']) && filter_var($_POST['confirm'], FILTER_VALIDATE_BOOLEAN)) {
            $user->banned = $user->banned ? 0 : 1;
            $user->dateBanned = (new DateTime())->format('Y-m-d H:i:s');
            $this->model->updateUser($user);
         }
         header('location: ' . $redirect);
         return;
      }
      $this->view->render('users/ban', ['user' => $user, 'redirect' => $redirect]);
   }

   /**
    *
    */
   public function logout(): void
   {
      $this->helper->clearUserSession();
      header('Location: ' . URL_ROOT . '/pages/index');
   }
}
