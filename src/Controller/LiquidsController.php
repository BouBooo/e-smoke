<?php

namespace App\Controller;

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
        $items = $paginator->paginate($liquids->findAllQuery(),
                                    $request->query->getInt('page', 1),
                                    20 // limit
        );
        return $this->render('liquids/index.html.twig', [
            'controller_name' => 'LiquidsController',
            'liquids' => $items
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

