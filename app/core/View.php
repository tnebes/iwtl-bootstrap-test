<?php

declare(strict_types=1);

class View
{
   private $template;

   /**
    * 'formTemplate' can also be used
    */
   public function __construct(string $template = 'defaultTemplate')
   {
      $this->template = $template;
   }

   public function render(string $page, array $parameters = [])
   {
      ob_start();
      extract($parameters);
      require APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $page . '.phtml';
      $content = ob_get_clean();
      require APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->template . '.phtml';
   }
}
