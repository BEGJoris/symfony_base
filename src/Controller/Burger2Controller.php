<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Burger2Controller extends AbstractController
{
    #[Route('/burger2', name: 'app_burger2')]
    public function index(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findAll();
        return $this->render('burger2/index.html.twig', [
            'burgers' => $burgers,
            "controller_name" => "Burger2Controller"
        ]);
    }

    #[Route('/burger2/create', name: 'burger2_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $burger = new Burger();
        $burger->setName("Krabby Patty");
        $burger->setPrice(5.99);
        $entityManager->persist($burger);
        $entityManager->flush();
        return new Response('Created burger ' . $burger->getId());
    }

}
