<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Model;
use App\Form\BrandAddType;
use App\Form\ModelAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('back/admin/index.html.twig', []);
    }

    #[Route('/admin/addBrand', name: 'app_add_brand')]
    public function addBrand(Request $request): Response
    {
        $brandEntity = new Brand();
        $form = $this->createForm(BrandAddType::class, $brandEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($brandEntity);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_form_listing_validation');
        }
        return $this->render('back/form/addBrand.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/addModel', name: 'app_add_model')]
    public function addModel(Request $request): Response
    {
        $modelEntity = new Model();
        $form = $this->createForm(ModelAddType::class, $modelEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($modelEntity);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_form_listing_validation');
        }
        return $this->render('back/form/addModel.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
