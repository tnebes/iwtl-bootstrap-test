<?php declare(strict_types = 1);

   require_once('core' . DIRECTORY_SEPARATOR . 'config.php');
   require_once('core' . DIRECTORY_SEPARATOR . 'App.php');
   require_once('core' . DIRECTORY_SEPARATOR . 'Controller.php');
   require_once('core' . DIRECTORY_SEPARATOR . 'Database.php');
   require_once('core' . DIRECTORY_SEPARATOR . 'Model.php');
   require_once('core' . DIRECTORY_SEPARATOR . 'Image.php');
   require_once('helpers' . DIRECTORY_SEPARATOR . 'sessionHelper.php');
   require_once('helpers' . DIRECTORY_SEPARATOR . 'debugHelper.php');

   $app = new App();