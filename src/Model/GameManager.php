<?php

namespace App\Model;

class GameManager extends AbstractManager
{
    public const TABLE = 'game';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectWithCategory()
    {
        return $this->pdo->query(
            'SELECT g.*, c.name as category ' .
            'FROM ' . self::TABLE . ' g ' .
            'LEFT JOIN category c ON g.category_id=c.id'
        )->fetchAll();
    }

    public function insert(array $game)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (name, price, player_number, description, image, category_id)
             VALUES(:name, :price, :player_number, :description, :image, :category)"
        );
        $statement->bindValue('name', $game['name'], \PDO::PARAM_STR);
        $statement->bindValue('player_number', $game['player_number'], \PDO::PARAM_INT);
        $statement->bindValue('description', $game['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $game['price']);
        $statement->bindValue('image', $game['image']);
        $statement->bindValue('category', $game['category']);

        $statement->execute();
    }
}
