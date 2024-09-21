<?php

namespace App\Controller;

use App\Repository\SauceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Sauce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SauceController extends AbstractController
{
    #[Route('/sauce', name: 'app_sauce')]
    public function index(SauceRepository $sauceRepository): Response
    {
        $sauces = $sauceRepository->findAll();
        return $this->render('sauce/index.html.twig', [
            'sauces' => $sauces,
            "controller_name" => "SauceController"
        ]);
    }

    #[Route('/sauce/create', name: 'sauce_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $sauce = new Sauce();
        $sauce->setName('Sauce tomate');
        $entityManager->persist($sauce);
        $entityManager->flush();
        return new Response('Created sauce ' . $sauce->getId());
    }
}
