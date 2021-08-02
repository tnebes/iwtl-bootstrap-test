<?php declare(strict_types = 1);

   class App
   {
      protected $currentController = 'Pages';
      protected $currentAction = 'index';
      protected $currentParams = [];

      public function __construct()
      {
         $skipMethod = false;
         $url = $this->getURL();
         if (!$url)
         {
            $url[0] = $this->currentController;
            $url[1] = $this->currentAction;
         }

         if (file_exists(APP_ROOT . '/controllers/' . ucwords($url[0]) . '.php'))
         {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
         }
         else
         {
            $this->currentController = 'Error';
            $this->currentMethod = 'notFound';
            $skipMethod = true;
         }

         if (!$skipMethod && isset($url[1]))
         {
            if (method_exists($this->currentController, $url[1]))
            {
               $this->currentAction = $url[1];
               unset($url[1]);
            }
            else
            {
               $this->currentAction = 'notFound';
            }
         }

         $this->currentParams = $url ? array_values($url) : [];
         call_user_func_array([$this->currentController, $this->currentMethod], $this->currentParams);
      }

      /**
       * Function returns an array that should contain the controller, the method and the parameters.
       */
      public function getURL() : array
      {
         $url = [];
         if (isset($_GET['url']))
         {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
         }
         return $url;
      }

   }