<?php

namespace App\Mail;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer {
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($email)
    {
        $email = (new TemplatedEmail())
            ->from('eventumesprit@gmail.com')
            ->to($email)
            ->subject('Confrimation du Reservation ')

            // path of the Twig template to render
            ->htmlTemplate('emails/email.html.twig')


        ;

        $this->mailer->send($email);
    }
}