<?php

namespace App\Controller;

use App\Entity\Liquid;
use App\Form\LiquidType;
use App\Repository\LiquidRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(LiquidRepository $liquids, Request $request, PaginatorInterface $paginator)
    {
        $items = $paginator->paginate($liquids->findAllQuery(),
                                    $request->query->getInt('page', 1),
                                    12 // limit
        );

        return $this->render('admin/index.html.twig', [
            'liquids' => $items
        ]);
    }

    /**
     * @Route("/admin/new", name="new_liquid")
     *
     * @param Request $request
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $liquid = new Liquid();

        $form = $this->createForm(LiquidType::class, $liquid);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($liquid);
            $manager->flush();
            $this->addFlash('success', 'Produit ajouté avec succès');
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/create.html.twig', [
            'liquid' => $liquid,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="edit_liquid")
     */
    public function edit(Liquid $liquid, ObjectManager $manager, Request $request) 
    {
        $form = $this->createForm(LiquidType::class, $liquid);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->flush();
            $this->addFlash('success', 'Produit modifié avec succès');
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', [
            'liquid' => $liquid,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="delete_liquid")
     */
    public function delete(Liquid $liquid, ObjectManager $manager)
    {
        $manager->remove($liquid);
        $manager->flush();
        $this->addFlash('success', 'Produit supprimé avec succès');

        return $this->redirectToRoute('admin');
    }
}
