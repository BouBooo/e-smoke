<?php

namespace App\Controller;

use App\Repository\LiquidRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(LiquidRepository $liquids)
    {
        $items = $liquids->findLatest();
        return $this->render('home/index.html.twig', [
            'liquids' => $items
        ]);
    }
}
