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
        $statement->bindParam(':filePath', $filePath);
        $statement->bindParam(':altText', $altText);
        $statement->bindParam(':suggestion', $suggestionId);
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

    /**
     * Function used to determine the random name of an uploaded image based on ids. This should never go wrong, now can it?
     */
    public function getMaxId() : ?int
    {
        $sql = "SELECT MAX(id) from $this->TABLE_NAME;";
        $statement = $this->dbHandler->prepare($sql);
        $statement->execute();
        // cursed
        return (int) $statement->fetchAll()[0][0] ?? null;
    }
 
}