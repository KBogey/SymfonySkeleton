<?php

namespace App\Controller;

use App\Form\ListingAddType;
use App\Entity\Listing;
use App\Repository\BrandRepository;
use App\Repository\ListingRepository;
use App\Repository\ModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private ListingRepository $listingRepository,
        private ModelRepository $modelRepository,
        private BrandRepository $brandRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $listingEtities = $this->listingRepository->findAll();

        return $this->render('front/home/index.html.twig', [
            'listings' => $listingEtities,
        ]);
    }

    #[Route('/addListing', name: 'app_add_listing')]
    public function indexAllListings(Request $request): Response
    {
        $listingEntity = new Listing();
        $form = $this->createForm(ListingAddType::class, $listingEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($listingEntity);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_form_listing_validation');
        }

        return $this->render('front/listing/addFormListing.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/formValidation', name: 'app_form_validation')]
    public function formValidation(): Response
    {
        return $this->render('shared/formValidation.html.twig');
    }

    #[Route('listingDetail/{listingId}', name: 'app_listing_detail')]
    public function listingDetail($listingId): Response
    {
        $listingEntity = $this->listingRepository->find($listingId);

        return $this->render('front/listing/detail.html.twig', [
            'listing' => $listingEntity,
        ]);
    }
}
