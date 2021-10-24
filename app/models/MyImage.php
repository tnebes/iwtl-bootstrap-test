<?php declare(strict_types = 1);

class MyImage extends Model
{
    public function __construct()
    {
       parent::__construct();
       $this->TABLE_NAME = 'image';
    }

    public function createImage(int $userId, string $filePath, string $altText, int $suggestionId = null) : int
    {
        $sql = "INSERT INTO $this->TABLE_NAME (user, filePath, altText, suggestion) values (:userId, :filePath, :altText, :suggestion);";
        $statement = $this->dbHandler->prepare($sql);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        return (int) $this->dbHandler->lastInsertId();
    }

    public function deleteImage(int $imageId) : bool
    {

        return false;
    }

    public function editImage(int $imageId, int $userId, string $filePath, string $altText, int $suggestionId = null) : bool
    {

        return false;
    }
 
}