<?php

namespace App\Notification;

use App\Data\ContactData;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailNotification
{
    public function __construct(private MailerInterface $mailer)
    { 
    }

    public function sendMail(ContactData $contact)
    {
        $email = (new TemplatedEmail())
            ->from($contact->email)
            ->to(new Address('iut-info@univ-littoral.fr'))
            ->subject('Nouvelle demande')
            ->htmlTemplate('mail/contact.html.twig')
            ->context([
                'contact' => $contact,
            ])
        ;
        $this->mailer->send($email);
    }
}
