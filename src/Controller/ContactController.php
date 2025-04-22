<?php

namespace App\Controller;

use App\Data\ContactData;
use App\Form\ContactType;
use App\Notification\MailNotification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact', name: 'contact.')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, MailNotification $mailNotification): Response
    {
        $contact = new ContactData();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $mailNotification->sendMail($contact);
                $this->addFlash('success', "Mail envoyé");
                return $this->redirectToRoute('contact.index');
            }catch(\Exception $exception){
                $this->addFlash('danger', "Erreur d'envoi de mail ".$exception->getMessage());
            }
        }

        return $this->render('contact/index.html.twig', compact('form'));
    }
}
