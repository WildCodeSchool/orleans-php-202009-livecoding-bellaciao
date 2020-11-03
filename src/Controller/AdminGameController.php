<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\CategoryManager;
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

        if (empty($game['name'])) {
            $errors[] = 'Le nom est obligatoire';
        }
        $length = 100;
        if (strlen($game['name']) > $length) {
            $errors[] = 'Le nom ne doit pas dépasser ' . $length . ' caractères';
        }
        if (!empty($game['player_number']) && $game['player_number'] < 0) {
            $errors[] = 'Le nombre de joueur doit être positif';
        }
        if (!empty($game['price']) && $game['price'] < 0) {
            $errors[] = 'Le prix doit être positif';
        }
        if (!empty($game['image']) && !filter_var($game['image'], FILTER_VALIDATE_URL)) {
            $errors[] = 'L\'image doit être une URL valide';
        }

//        $categoryManager = new CategoryManager();
//        $categories = $categoryManager->selectAll();
//        $categorieIds = array_column($categories, 'id');
//        if(!in_array($game['category'], $categorieIds)) {
//            $errors[] = 'La catégorie n\'est pas valide';
//        }
        return $errors ?? [];
    }
}
