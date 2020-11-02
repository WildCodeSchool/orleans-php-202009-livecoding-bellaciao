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
}
