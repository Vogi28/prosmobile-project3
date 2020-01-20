<?php

namespace App\Service;

use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendRegNotif(string $emailAdress)
    {
        $email = (new Email())
                ->from('username@domain.com')
                ->to($emailAdress)
                ->subject('Confirmation d\'enregistrement')
                ->text('Bienvenue chez PROSmobile');
        
        $this->mailer->send($email);
    }

    public function sendMdpNotif(string $emailAdress)
    {
        $email = (new Email())
                ->from('username@domain.com')
                ->to($emailAdress)
                ->subject('Changement de mot de passe')
                ->text('Le changement de votre mot de passe a bien ete pris en compte');
        
        $this->mailer->send($email);
    }

    public function sendReza(string $customer, array $articles)
    {
        $articles;
        $email = (new Email())
                ->from('username@domain.com')
                ->to($customer)
                ->subject('Réservation')
                ->text('Votre commande numéro **** a bien ete enregistre');
        
        $this->mailer->send($email);

        $email2 = (new Email())
                ->from('username@domain.com')
                ->to('shinjuo.ng@gmail.com')
                ->subject('Réservation')
                ->text('Bienvenue chez PROSmobile');
        
        $this->mailer->send($email2);
    }
}
