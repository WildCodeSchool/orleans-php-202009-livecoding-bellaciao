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
            'JOIN category c ON g.category_id=c.id'
        )->fetchAll();
    }
}
