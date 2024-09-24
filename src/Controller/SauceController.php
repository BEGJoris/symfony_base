<?php

namespace App\Controller;

use App\Repository\SauceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Sauce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SauceType;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/sauce/new', name: 'sauce_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sauce = new Sauce();
        $form=$this->createForm(SauceType::class,$sauce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($sauce);
            $entityManager->flush();
            return $this->redirectToRoute('app_sauce');
        }
        return $this->render('sauce/new.html.twig', [
            'form' => $form
        ]);
    }
}
