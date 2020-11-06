<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\CategoryManager;
use App\Model\GameManager;
use App\Utils\Validation;

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

    public function add()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $game = array_map('trim', $_POST);
            $errors = $this->validateGame($game);
            if (empty($errors)) {
                $gameManager = new GameManager();
                $gameManager->insert($game);

                header("Location: /adminGame/index");
            }
        }

        return $this->twig->render('AdminGame/add.html.twig', [
            'errors'     => $errors ?? [],
            'game'       => $game ?? [],
            'categories' => $categories,
        ]);
    }

    private function validateGame(array $game): array
    {
        $errors = [];

        $validation = new Validation();
        $errors[] = $validation->required('name', $game['name']);
        $errors[] = $validation->maxLength('name', $game['name'], 100);
        $errors[] = $validation->moreThan('price', $game['price'], 0);
        $errors[] = $validation->moreThan('nombre de joueurs', $game['player_number'], 0);
        if (!empty($game['image']) && !filter_var($game['image'], FILTER_VALIDATE_URL)) {
            $errors[] = 'L\'image doit être une URL valide';
        }

        return $errors ?? [];
    }
}
