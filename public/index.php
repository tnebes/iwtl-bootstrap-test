<?php

declare(strict_types=1);

require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php');

session_start();

/**
 * Require the helpers
 */
// exit(APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . '*.php');
// foreach (glob(APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'helpers'. DIRECTORY_SEPARATOR . '*.php') as $filename)
// {
//    require_once($filename);
// }

$path = implode(
   PATH_SEPARATOR,
   [
      APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers',
      APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'models',
      APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'core',
      APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'helpers',
   ]
);

set_include_path($path);

spl_autoload_register(function ($class) {
   $paths = explode(PATH_SEPARATOR, get_include_path());
   foreach ($paths as $path) {
      $classPath = $path . DIRECTORY_SEPARATOR . $class . '.php';
      // echo $classPath . '<br/>';
      if (file_exists($classPath)) {
         require($classPath);
         break;
      }
   }
});

require_once '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
App::start();
