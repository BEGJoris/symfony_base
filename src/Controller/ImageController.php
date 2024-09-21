<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
