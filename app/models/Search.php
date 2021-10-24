<?php declare(strict_types = 1);

class Search extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function searchUsers(string $searchTerm) : array
    {
        $searchTerm = '%' . $searchTerm . '%';
        $sql = "SELECT id, username FROM user WHERE
            username like :searchTerm;";
        $statement = $this->dbHandler->prepare($sql);
        $statement->bindParam(':searchTerm', $searchTerm);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function searchTopics(string $searchTerm) : array
    {
        $searchTerm = '%' . $searchTerm . '%';
        $sql = "SELECT id, `name`, CONCAT(LEFT(`description`, 50), '...') as `description` FROM topic WHERE
            `description` LIKE :searchTerm;
            OR `name` LIKE :searchTerm;";
        $statement = $this->dbHandler->prepare($sql);
        $statement->bindParam(':searchTerm', $searchTerm);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function searchSuggestions(string $searchTerm) : array
    {
        $searchTerm = '%' . $searchTerm . '%';
        $sql = "SELECT topic, title, CONCAT(LEFT(shortDescription, 50), '...') as shortDescription FROM suggestion WHERE
            title LIKE :searchTerm
            OR shortDescription LIKE :searchTerm
            OR longDescription LIKE :searchTerm;";
        $statement = $this->dbHandler->prepare($sql);
        $statement->bindParam(':searchTerm', $searchTerm);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}