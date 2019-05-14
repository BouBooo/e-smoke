<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Form\MarkType;
use App\Repository\MarkRepository;
use App\Repository\LiquidRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMarkController extends AbstractController
{
    /**
     * @Route("/admin/marks", name="admin_marks")
     */
    public function index(LiquidRepository $liquids, MarkRepository $marks, Request $request, PaginatorInterface $paginator)
    {
        
        $items = $paginator->paginate($marks->findAllQuery(),
                                    $request->query->getInt('page', 1),
                                    12 // limit
        );

        return $this->render('admin_mark/index.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * @Route("/admin/marks/new", name="new_mark")
     *
     * @param Request $request
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $mark = new Mark();

        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($mark);
            $manager->flush();
            $this->addFlash('success', 'Marque ajoutée avec succès');
            return $this->redirectToRoute('admin_marks');
        }

        return $this->render('admin_mark/create.html.twig', [
            'mark' => $mark,
            'form' => $form->createView()
        ]);
    }
}
