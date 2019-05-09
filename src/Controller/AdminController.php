<?php

namespace App\Controller;

use App\Entity\Liquid;
use App\Form\LiquidType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/new", name="new_liquid")
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        $liquid = new Liquid();

        $form = $this->createForm(LiquidType::class, $liquid);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->manager->persist($liquid);
            $this->manager->flush();
            $this->addFlash('success', 'Produit ajouté avec succès');
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/create.html.twig', [
            'liquid' => $liquid,
            'form' => $form->createView()
        ]);
    }
}
