<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\CategoryManager;
use App\Model\GameManager;
use App\Service\Validator;

class AdminGameController extends AbstractController
{
    public const MAX_FILE_SIZE = 1000000;
    public const AUTHORIZED_MIMES = ['image/jpeg', 'image/png', 'image/gif'];

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
            $errors = $this->validateGame($game, $_FILES['image']);

            if (empty($errors)) {
                $filename = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename);
                $game['image'] = $filename;

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

    private function validateGame(array $game, array $file): array
    {
        $errors = [];

        $validator = new Validator('nom', $game['name']);
        $validator
            ->required()
            ->shorterThan(255);
        $nameErrors = $validator->getErrors();

        $validator = new Validator('nombre de joueurs', $game['player_number']);
        $validator->moreThan(0);
        $playerErrors = $validator->getErrors();

        $validator = new Validator('prix', $game['price']);
        $validator->moreThan(0);
        $priceErrors = $validator->getErrors();

        $errors = [...$nameErrors, ...$playerErrors, ...$priceErrors];

        // taille
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $errors[] = 'Le fichier ne doit pas excéder ' . self::MAX_FILE_SIZE / 1000000 . ' Mo';
        }
        // type mime
        if (!empty($file['tmp_name']) && !in_array(mime_content_type($file['tmp_name']), self::AUTHORIZED_MIMES)) {
            $errors[] = 'Ce type de fichier n\'est pas valide';
        }

        return $errors ?? [];
    }
}
