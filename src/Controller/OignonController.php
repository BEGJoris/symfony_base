<?php

namespace App\Controller;

use App\Repository\OignonRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Oignon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OignonController extends AbstractController
{
    #[Route('/oignon', name: 'app_oignon')]
    public function index(OignonRepository $oignonRepository): Response
    {
        $oignons = $oignonRepository->findAll();
        return $this->render('oignon/index.html.twig', [
            'oignons' => $oignons,
            'controller_name' => 'OignonController'
        ]);
    }

    #[Route('/oignon/create', name: 'oignon_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $oignon = new Oignon();
        $oignon->setName('Oignon rouge');

        // Persister et sauvegarder l'oignon
        $entityManager->persist($oignon);
        $entityManager->flush();

        return new Response('Oignon créé avec succès !');
    }



}
