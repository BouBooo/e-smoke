<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Liquid;
use App\Repository\UserRepository;
use App\Repository\LiquidRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{

    private $em;
    private $repository;

    public function __construct(ObjectManager $em, LiquidRepository $repository) {
        $this->em = $em;
        $this->repository = $repository;
    }


    /**
     * @Route("/panier/{id}", name="getPanier")
     */
    public function getPanier(User $user, int $id)
    {
        $panier = $user->getPanier();

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'panier' => $panier,
            'id' => $id
        ]);
    }

    /**
     * @Route("/liquids/{id}/add", name="addToPanier")
     */
    public function addToPanier($id, Liquid $liquid, LiquidRepository $repo, UserRepository $user_repo, UserInterface $userInt, ObjectManager $manager) {
        //User
        $userId = $userInt->getId();
        $userInfos = $user_repo->find($userId); 
        // Liquid
        $item = $repo->find($id);

        // Add liquid to panier
        $panier = $userInfos->addPanier($item);
        $manager->persist($panier);
        $manager->flush();

        return $this->redirectToRoute('getPanier', [
            'id' => $userId
        ]);
    }

}
