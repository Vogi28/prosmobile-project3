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
}
