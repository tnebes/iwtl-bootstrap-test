<?php declare(strict_types = 1);

class ImageGetter
{

   public static function getImage(string $imagePath, ?string $imageType = 'png', ?string $altText = '', ?int $x = 400, ?int $y = 400) : void
   {
      if (file_exists($imagePath)) {
        //  echo 'data:image/' . $imageType . ';base64,' . base64_encode(file_get_contents($imagePath));
         echo '<img src="data:image/' . $imageType . ';base64,' . base64_encode(file_get_contents($imagePath)) . '" alt="'. $altText ?? $altText .'" class="img-fluid img-thumbnail mx-auto d-block" style="max-width: 100%;">';
      } else {
          // TODO: insecure - shows server path. this needs to be done.
         echo 'Image not found! Intended file location: ' . $imagePath;
      }
   }
}