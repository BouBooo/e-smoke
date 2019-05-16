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
    /**
     * @Route("/panier/{id}", name="getPanier")
     */
    public function getPanier(User $user, int $id)
    {
        $panier = $user->getPanier();

        return $this->render('panier/index.html.twig', [
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

    /**
     * @Route("/liquids/{id}/remove", name="removeFromPanier")
     */
    public function removeFromPanier($id, Liquid $liquid, LiquidRepository $repo, UserRepository $user_repo, UserInterface $userInt, ObjectManager $manager) {
        $userId = $userInt->getId();
        $userInfos = $user_repo->find($userId); 

        $item = $repo->find($id);

        // Remove liquid from panier
        $panier = $userInfos->removePanier($item);
        $manager->persist($panier);
        $manager->flush();

        return $this->redirectToRoute('getPanier', [
            'id' => $userId
        ]);
    }
    
    /**
     * @Route("/panier/{id}/clean", name="clean_panier")
     */
    public function cleanPanier(User $user, ObjectManager $manager)
    {
        $userId = $user->getId();
        $liquids = $user->getPanier();

        foreach($liquids as $liquid) {
            $clean = $user->removePanier($liquid);
            $manager->persist($clean);
            $manager->flush();
        }
        return $this->redirectToRoute('getPanier', [
            'id' => $userId
        ]);
    }

}
