<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BurgerController extends AbstractController
{
    #[Route('/burgers', name: 'burgers')]
    
    public function list(): Response
    {
        return $this->render('burgers_list.html.twig', [
            'controller_name' => 'BurgerController',
            'burgers' => [
                [
                    'name' => 'Cheeseburger',
                    'price' => 5.99
                ],
                [
                    'name' => 'Hamburger',
                    'price' => 3.99
                ],
                [
                    'name' => 'Fries',
                    'price' => 1.99
                ]
            ]
        ]);
        
    }
    #[Route('/burgers/{id}', name: 'burger')]
    public function show($id): Response
    {
        $burgers = [
            1 => [
                'name' => 'Cheeseburger',
                'price' => 5.99
            ],
            2 => [
                'name' => 'Hamburger',
                'price' => 3.99
            ],
            3 => [
                'name' => 'Fries',
                'price' => 1.99
            ]
        ];
        $burger = $burgers[$id] ?? null;
        return $this->render('burger_show.html.twig', [
            'burger' => $burger
        ]);
    }
}