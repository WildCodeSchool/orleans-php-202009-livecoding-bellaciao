<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\GameManager;

class GameController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $gameManager = new GameManager();
        $games = $gameManager->selectWithCategory();

        return $this->twig->render('Game/index.html.twig', [
            'games'     => $games,
            'favorites' => $_SESSION['favorites'] ?? [],
        ]);
    }

    public function show(int $id)
    {
        $gameManager = new GameManager();
        $game = $gameManager->selectOneById($id);

        return $this->twig->render('Game/show.html.twig', [
            'game' => $game,
        ]);
    }

    public function favorized(int $id)
    {
        $gameManager = new GameManager();
        $game = $gameManager->selectOneById($id);

        if (key_exists($id, $_SESSION['favorites'])) {
            unset($_SESSION['favorites'][$id]);
        } else {
            $_SESSION['favorites'][$id] = $game;
        }
        header("Location: /game/index");
    }

    public function favorite()
    {
        $games = $_SESSION['favorites'];

        return $this->twig->render('Game/favorite.html.twig', [
            'games' => $games,
        ]);
    }
}
