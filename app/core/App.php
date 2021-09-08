<?php declare(strict_types = 1);

class App
{
   public static function start()
   {
      $route = isset($_SERVER['REDIRECTION_PATH_INFO']) ? $_SERVER['REDIRECTION_PATH_INFO'] : $_SERVER['REQUEST_URI'];
      $path = explode('/', $route);

      $class = '';
      if (!isset($path[1]) || empty($path[1]))
      {
         $class = 'Pages';
      }
      else
      {
         $class = ucwords($path[1]);
      }
      // $class .= 'Controller';

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
         $instance->$method;
      }
      else
      {
         $class = 'ErrorPages';
         $method = 'notFound';
         $instance = new $class;
         $instance->$method();
      }     
   }   
}