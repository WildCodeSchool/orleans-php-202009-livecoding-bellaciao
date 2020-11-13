<?php

namespace App\Controller;

use App\Service\Validator;

class ContactController extends AbstractController
{
    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $contact = array_map('trim', $_POST);
            $errors = $this->validate($contact);

            if (empty($errors)) {
                // mailer
                header("Location: /");
            }
        }

        return $this->twig->render('Contact/index.html.twig', [
            'errors'  => $errors ?? [],
            'contact' => $contact ?? [],
        ]);
    }

    private function validate(array $data)
    {
        $validator = new Validator('nom', $data['name']);
        $nameErrors = $validator->required()->shorterThan(255)->getErrors();
        $validator = new Validator('email', $data['email']);
        $emailErrors = $validator->required()->shorterThan(255)->isEmail()->getErrors();
        $validator = new Validator('message', $data['message']);
        $messageErrors = $validator->required()->getErrors();

        return [...$emailErrors, ...$nameErrors, ...$messageErrors];
    }
}
