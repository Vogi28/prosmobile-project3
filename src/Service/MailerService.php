<?php

namespace App\Service;

use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

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

    public function sendReza(string $customer, array $articles, $commande)
    {
        $articles;
        $commande;
        $email = (new TemplatedEmail())
                ->from('username@domain.com')
                ->to($customer)
                ->subject('Réservation numéro '.$commande->getId())
                ->text('Bienvenue chez PROSmobile');
                
                
        
        $this->mailer->send($email);
        
            $email2 = (new TemplatedEmail())
                ->from('username@domain.com')
                ->to('shinjuo.ng@gmail.com')
                ->subject('Votre réservation numéro '.$commande->getId().' a bien ete enregistre')
                ->htmlTemplate('mailTemplate/customersMailTemplate.html.twig')
                ->context(['articles' => $articles]);
        
        $this->mailer->send($email2);
    }
}
