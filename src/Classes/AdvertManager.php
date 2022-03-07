<?php

require_once './db/DataBase.php';

class AdvertManager extends DataBase
{

    /** 
     * Table "advert" 
     */
    private string $advert = 'advert';

    /** 
     * Table "category"
     */
    private string $category = 'category';

    /**
     * Add Advert
     * 
     * @return int
     */
    public function addAdvert(AdvertEntity $advertEntity): int
    {
        $addAdvert = $this->getPDO()->prepare(
            "INSERT INTO {$this->advert} (title, description, postcode, city, price, category_id)
                VALUE(:title, :description, :postcode, :city, :price, :category_id)"
        );
        $addAdvert->bindValue(':title', $advertEntity->getTitle(), PDO::PARAM_STR);
        $addAdvert->bindValue(':description', $advertEntity->getDescription(), PDO::PARAM_STR);
        $addAdvert->bindValue(':postcode', $advertEntity->getPostcode(), PDO::PARAM_STR);
        $addAdvert->bindValue(':city', $advertEntity->getCity(), PDO::PARAM_STR);
        $addAdvert->bindValue(':price', $advertEntity->getPrice(), PDO::PARAM_INT);
        $addAdvert->bindValue(':category_id', $advertEntity->getCategory_id(), PDO::PARAM_INT);
        // $addAdvert->bindValue(':created_at', $advertEntity->getCreated_at(), PDO::PARAM_STR);

        $addAdvert->execute();

        return $addAdvert->rowCount();
    }

    /** 
     * Show Article
     * @return array|false
     */
    public function showAllArticle()
    {
        return $this->getPDO()->query(
            "SELECT * FROM {$this->advert} 
                INNER JOIN {$this->category}
                    WHERE {$this->advert}.category_id = {$this->category}.id_category"
        )->fetchAll();
    }

    /** 
     * Show Category List
     * @return array|false
     */
    public function showCategoryList()
    {
        return $this->getPDO()->query(
            "SELECT * FROM {$this->category}"
        )->fetchAll();
    }

    /**
     * Récupère les 15 dernières annonces
     * @return array
     */
    public function getLastAdverts(): array
    {
        return $this->getPDO()->query(
            "SELECT {$this->advert}.id_advert, 
                    {$this->advert}.title, 
                    {$this->advert}.description, 
                    {$this->advert}.postcode, 
                    {$this->advert}.city, 
                    {$this->advert}.price, 
                    {$this->category}.value AS {$this->category}, 
                    DATE_FORMAT({$this->advert}.created_at, '%d/%m/%Y') AS created_at	  
	                    FROM {$this->advert} 
                            INNER JOIN {$this->category} WHERE {$this->category}.id_{$this->category} = {$this->advert}.{$this->category}_id
	                            ORDER BY advert.created_at DESC LIMIT 15"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère toutes les annonces
     * @return array
     */
    public function getAllAdverts(): array
    {
        return $this->getPDO()->query(
            "SELECT {$this->advert}.id_advert, 
                                {$this->advert}.title, 
                                {$this->advert}.description, 
                                {$this->advert}.postcode, 
                                {$this->advert}.city, 
                                {$this->advert}.price, 
                                category.value AS category, 
                                DATE_FORMAT({$this->advert}.created_at, '%d/%m/%Y') AS created_at 
	                                FROM {$this->advert} 
                                        INNER JOIN category WHERE category.id_category = {$this->advert}.category_id"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère less infos d'une annonce
     * @param integer $id
     */
    public function getAdvertById(int $id): mixed
    {
        $requete = $this->getPDO()->prepare(
            "SELECT *, {$this->category}.value AS category, 
                        DATE_FORMAT(created_at, '%d/%m/%Y') AS created_at 
                        FROM {$this->advert} 
                        INNER JOIN {$this->category} WHERE {$this->category}.id_category = advert.category_id AND advert.id_advert = :id"
        );
        $requete->bindValue(':id', intval($id), PDO::PARAM_INT);
        $requete->execute();
        return $requete->fetch();
    }

    /**
     * Undocumented function
     *
     * @param array 
     * @return int
     */
    // Update a  guitar in the bdd and returns the status
    public function updateAdvertFromArray(AdvertEntity $advert)
    {
        // Préparation de la requète SQL
        $update_advert = $this->getPDO()->prepare(
            "UPDATE `{$this->advert}` SET `title` = :title, `description` = :description, `postcode` = :postcode, `city`= :city, `price` = :price, `category_id` = :category_id WHERE `id_advert` = :id;"
        );
        // On associe les différentes variables aux marqueurs en respectant les types
        $update_advert->bindValue(':id', $advert->getId_avert(), PDO::PARAM_INT);
        $update_advert->bindValue(':title', $advert->getTitle(), PDO::PARAM_STR);
        $update_advert->bindValue(':description', $advert->getDescription(), PDO::PARAM_STR);
        $update_advert->bindValue(':postcode', $advert->getPostcode(), PDO::PARAM_INT);
        $update_advert->bindValue(':city', $advert->getCity(), PDO::PARAM_STR);
        $update_advert->bindValue(':price', $advert->getPrice(), PDO::PARAM_INT);
        // $update_advert->bindValue(':reservation_message', $advert->getReservation_message(), PDO::PARAM_STR);
        $update_advert->bindValue(':category_id', $advert->getCategory_id(), PDO::PARAM_INT);
        // On execute la requète
        $update_advert->execute();
        $update_advert->closeCursor();
        return ($update_advert->rowCount());
    }

    /**
     * Supprime uune annonce
     *
     * @param integer $id
     * @return int
     */
    public function deleteAdvertById(int $id)
    {
        $delete_advert = $this->getPDO()->prepare("DELETE FROM {$this->advert} WHERE id_advert = :id");
        $delete_advert->bindValue(':id', $id, PDO::PARAM_INT);
        $delete_advert->execute();
        $delete_advert->closeCursor();

        return $delete_advert->rowCount();
    }

    public function book($id, $message)
	{
		       // Préparation de la requète SQL
			   $book = $this->getPDO()->prepare("UPDATE `advert` SET `reservation_message` = :reservation_message WHERE `id_advert` = :id");
			   // On associe les différentes variables aux marqueurs en respectant les types
			   $book->bindValue(':id', intval($id), PDO::PARAM_INT);
			   $book->bindValue(':reservation_message', $message, PDO::PARAM_STR);
			   // On execute la requète
			   $book->execute();
			   $book->closeCursor();    
			   return( $book->rowCount() );
	}
}
