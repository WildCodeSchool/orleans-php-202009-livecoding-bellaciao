<?php

namespace App\Controller;

use App\Service\Validator;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $contact = array_map('trim', $_POST);
            $errors = $this->validate($contact);

            if (empty($errors)) {
                // mailer
                // adresse de destination => admin@bellaciao.fr
                // message
                // nom + mail de l'expéditeur
                // mail + password pour envoyer
                $transport = Transport::fromDsn(MAILER_DSN);
                $mailer = new Mailer($transport);
                $email = (new Email())
                    ->from($contact['email'])
                    ->to(MAIL_TO)
                    ->subject('Message du site web Bellaciao')
                    ->html($this->twig->render('Contact/email.html.twig', [
                        'contact' => $contact,
                    ]));

                $mailer->send($email);
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
