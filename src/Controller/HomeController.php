<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\LiquidRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\ContactNotificationController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(LiquidRepository $liquids, Request $request, ContactNotificationController $contactMail)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $contactMail->notify($contact);
            $this->addFlash('success', 'Notre avons bien reçu votre message. Nous vous repondrons dans les 48h.');
            return $this->redirectToRoute('home');
        }
        
        $items = $liquids->findLatest();

        return $this->render('home/index.html.twig', [
            'liquids' => $items,
            'form' => $form->createView()
        ]);
    }
}
