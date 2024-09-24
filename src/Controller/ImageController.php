<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ImageType;
use App\Entity\Image;

class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findAll();
        return $this->render('image/index.html.twig', [

            'images' => $images,
            "controller_name" => "ImageController"
        ]);
    }
    #[Route('/image/{id}', name: 'app_image_show')]
    public function show($id, ImageRepository $imageRepository): Response
    {
        $image = $imageRepository->find($id);
        return $this->render('image/show.html.twig', [
            'image' => $image
        ]);
    }

    #[Route('/image/new', name: 'app_image_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $image = new Image();
        $form=$this->createForm(ImageType::class,$image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_image');
        }


        return $this->render('image/new.html.twig',[
            "controller_name"=>"ImageController",
            "form"=>$form->createView()
        ]);
    }
}
