<?php

declare(strict_types=1);

class Image
{
   public function __construct(string $imagePath, string $imageType = 'png')
   {
      $this->getImage($imagePath, $imageType);
   }

   public function getImage(string $imagePath, string $imageType = 'png'): void
   {
      $imagePath = APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . $imagePath;
      if (file_exists($imagePath)) {
         echo 'data:image/' . $imageType . ';base64,' . base64_encode(file_get_contents($imagePath));
      } else {
         echo 'Image not found!';
      }
   }
}
