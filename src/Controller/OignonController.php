<?php

namespace App\Controller;

use App\Form\OignonType;
use App\Repository\OignonRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Oignon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/oignon/new', name: 'oignon_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response{

        $oignon = new Oignon();
        $form=$this->createForm(OignonType::class,$oignon);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($oignon);
            $entityManager->flush();

            return $this->redirectToRoute('app_oignon');
        }

        return $this->render('oignon/new.html.twig',[
            "controller_name"=>"OignonController",
            "form"=>$form->createView()
        ]);
    }



}
