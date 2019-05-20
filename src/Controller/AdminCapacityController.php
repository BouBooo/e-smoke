<?php

namespace App\Controller;

use App\Entity\Capacity;
use App\Form\CapacityType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCapacityController extends AbstractController
{
    /**
     * @Route("/admin/capacities", name="admin_capacities")
     */
    public function index()
    {
        return $this->render('admin_capacities/index.html.twig', [
            'controller_name' => 'AdminCapacityController',
        ]);
    }
    

    /**
     * @Route("/admin/capacities/new", name="new_capacity")
     *
     * @param Request $request
     */
    public function create(Request $request, ObjectManager $manager)
    {
        
    }

}
