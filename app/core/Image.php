<?php declare(strict_types = 1);

   Class Image
   {
      public function __construct(string $imagePath, string $imageType = 'png')
      {
         $this->getImage($imagePath, $imageType);
      }

      public function getImage(string $imagePath, string $imageType = 'png') : void
      {
         $imagePath = APP_ROOT . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . $imagePath;

         echo 'data:image/' . $imageType . ';base64,' . base64_encode(file_get_contents($imagePath));
      }
   }