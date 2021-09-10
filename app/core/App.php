<?php declare(strict_types = 1);

class App
{
   public static function start()
   {
      $route = isset($_SERVER['REDIRECTION_PATH_INFO']) ? $_SERVER['REDIRECTION_PATH_INFO'] : $_SERVER['REQUEST_URI'];
      $path = explode('/', $route);

      $class = 'Controller';
      if (!isset($path[1]) || empty($path[1]))
      {
         $class .= 'Pages';
      }
      else
      {
         $class .= ucwords($path[1]);
      }
      

      $method = '';
      if (!isset($path[2]) || empty($path[2]))
      {
         $method = 'index';
      }
      else
      {
         $method = ucwords($path[2]);
      }

      if (class_exists($class) && method_exists($class, $method))
      {
         $instance = new $class;
         $instance->$method((isset($path[3]) && !empty($path[3])) ? $path[3] : null);
      }
      else
      {
         $class = 'ControllerErrorPages';
         $method = 'notFound';
         $instance = new $class;
         $instance->$method();
      }     
   }   
}