<?php declare(strict_types=1);

require_once('core' . DIRECTORY_SEPARATOR . 'config.php');

$path = implode(
   PATH_SEPARATOR ,
   [
      APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers',
      APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'models',
      APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'core'
   ]
);

set_include_path($path);

spl_autoload_register(function($class){
   $paths = explode(PATH_SEPARATOR, get_include_path());
   foreach($paths as $path)
   {
      $classPath = $path . DIRECTORY_SEPARATOR . $class . '.php';
      if (file_exists($classPath))
      {
         require($classPath);
         break;
      }
   }
});


$app = new App();
