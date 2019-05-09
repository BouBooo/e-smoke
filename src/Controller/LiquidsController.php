<?php

namespace App\Controller;

use App\Repository\LiquidRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LiquidsController extends AbstractController
{
    /**
     * @Route("/liquids", name="liquids")
     */
    public function index(LiquidRepository $liquids)
    {
        $items = $liquids->findAll();
        return $this->render('liquids/index.html.twig', [
            'controller_name' => 'LiquidsController',
            'liquids' => $items
        ]);
    }
}

