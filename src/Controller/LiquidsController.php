<?php

namespace App\Controller;

use App\Entity\Liquid;
use App\Entity\LiquidSearch;
use App\Form\LiquidSearchType;
use App\Repository\LiquidRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LiquidsController extends AbstractController
{
    /**
     * @Route("/liquids", name="liquids")
     */
    public function index(LiquidRepository $liquids, PaginatorInterface $paginator, Request $request)
    {
        $search = new LiquidSearch();
        $form = $this->createForm(LiquidSearchType::class, $search);
        $form->handleRequest($request);

        $items = $paginator->paginate($liquids->findAllQuery(),
                                    $request->query->getInt('page', 1),
                                    12 // limit
        );
        return $this->render('liquids/index.html.twig', [
            'controller_name' => 'LiquidsController',
            'liquids' => $items,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("liquids/{id}", name="show_liquid")
     */
    public function show($id, Request $request, ObjectManager $manager, LiquidRepository $liquids)
    {
        $item = $liquids->find($id);
        return $this->render('liquids/show.html.twig', [
            'liquid' => $item
        ]);
    }
}

