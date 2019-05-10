<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\LiquidRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdminCategoriesController extends AbstractController
{
    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function index(CategoryRepository $categories, Request $request, PaginatorInterface $paginator)
    {
        //$categoryLiquids = $cat->getLiquids();
        $items = $paginator->paginate($categories->findAllQuery(),
                                    $request->query->getInt('page', 1),
                                    12 // limit
        );

        return $this->render('admin_categories/index.html.twig', [
            'items' => $items,
            //'liquids' => $categoryLiquids
        ]);
    }

    /**
     * @Route("/admin/categories/new", name="new_category")
     *
     * @param Request $request
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', 'Catégorie créée avec succès');
            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin_categories/create.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }
}
