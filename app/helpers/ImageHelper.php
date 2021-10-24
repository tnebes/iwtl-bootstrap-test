<?php

declare(strict_types=1);

class ImageHelper
{
    public static function validateImage(array $image): string
    {
        $ERRORS = [
            0 => "There is no error, the file uploaded with success.",
            1 => "The uploaded file exceeds the upload_max_filesize",
            2 => "The uploaded file exceeds the MAX_FILE_SIZE",
            3 => "The uploaded file was only partially uploaded.",
            4 => "No file was uploaded.",
            6 => "Missing a temporary folder.",
            7 => "Failed to write file to disk.",
            8 => "A PHP extension stopped the file upload."
        ];
        $type = explode('/', $image['type']);
        if ($image['error'] != 0)
        {
            return $ERRORS[$image['error']];
        }
        if ($type[0] != 'image') {
            return 'A valid image must be uploaded.';
        }
        return '';
    }

    public static function moveImage(array $image, int $suggestionId = null) : int
    {
        $myImage = new MyImage;
        $uniqueId = $myImage->getMaxId();
        if (is_null($uniqueId))
        {
            $uniqueId = 1;
        }
        $newFileName = UPLOAD_PATH . $uniqueId;// . '.' . (explode('/', $image['type'])[1]);
        // die(Helper::getInstance()->debugDisplay($image));
        // if (!move_uploaded_file($image['tmp_name'], $newFileName))
        // {
        //     die('Failed to upload file ' . $image['tmp_name'] . ' to ' . $newFileName);
        // }
        move_uploaded_file($image['tmp_name'], $newFileName);
        return $myImage->createImage((int) $_SESSION['id'], $newFileName, 'example alt text', $suggestionId);
    }
}
