<?php

namespace App\Controller;

use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        $commentaires = $commentaireRepository->findAll();
        return $this->render('commentaire/index.html.twig', [

            'commentaires' => $commentaires,
            "controller_name" => "CommentaireController"

            ]);
    }
    #[Route('/commentaire/create', name: 'commentaire_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setName('Ceci est un commentaire');
        $entityManager->persist($commentaire);
        $entityManager->flush();
        return new Response('Commentaire ajoute avec succès !');
    }
}
