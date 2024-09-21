<?php

namespace App\Controller;

use App\Entity\Pain;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PainController extends AbstractController
{
    #[Route('/pain', name: 'app_pain')]
    public function index(PainRepository $painRepository): Response
    {
        $pains = $painRepository->findAll();
        return $this->render('pain/index.html.twig', [

            'pains' => $pains,
            "controller_name" => "PainController"
        ]);
    }

    #[Route('/pain/create', name: 'pain_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $pain = new Pain();
        $pain->setName("Pain de mie");
        $entityManager->persist($pain);
        $entityManager->flush();
        return new Response('Created pain ' . $pain->getId());
    }
}
