<?php


namespace App\Controller;


use App\Controller\AbstractController;
use App\Model\GameManager;

class AdminGameController extends AbstractController
{
    public function index()
    {
        $gameManager = new GameManager();
        $games = $gameManager->selectAll();

        return $this->twig->render('AdminGame/index.html.twig', [
            'games' => $games,
        ]);
    }
}
