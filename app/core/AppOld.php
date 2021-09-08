<?php declare(strict_types = 1);

   class App
   {
      protected $currentController = 'Pages';
      protected $currentMethod = 'index';
      protected $currentParams = [];

      /**
       * Public constructor
       */
      public function __construct()
      {
         $skipMethod = false;
         $url = $this->getURL();
         if (!$url)
         {
            $url[0] = $this->currentController;
            $url[1] = $this->currentMethod;
         }

         /**
          * Checks whether the URL is correct and actually leads to something
          */
         if (file_exists(APP_ROOT . '/controllers/' . ucwords($url[0]) . '.php'))
         {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
         }
         else
         {
            $this->currentController = 'ErrorPages';
            $this->currentMethod = 'notFound';
            $skipMethod = true;
         }

         /**
          * Gets the appropriate controller PHP file
          */
         require_once '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $this->currentController . '.php';
         $this->currentController = new $this->currentController();

         if (!$skipMethod && isset($url[1]))
         {
            if (method_exists($this->currentController, $url[1]))
            {
               $this->currentMethod = $url[1];
               unset($url[1]);
            }
            else
            {
               require_once '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'ErrorPages' . '.php';
               $this->currentController = new ErrorPages();
               $this->currentMethod = 'notFound';
            }
         }

         /**
          * Calls the appropriate method within the controller object and sends the parameters.
          */
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