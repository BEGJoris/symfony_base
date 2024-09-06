<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DemoController extends AbstractController
{
    #[Route('/somme', name: 'somme')]
    public function somme(): Response
    {
        return $this->render('somme.html.twig');
    }
}