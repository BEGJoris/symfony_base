<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Form\BurgerType;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/burger2/filter', name: 'burger2_filter')]
    private function filter(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findBurgerWithIngredient("Oignon");
        return $this->render('burger2/index.html.twig', [
            'burgers' => $burgers,
            "controller_name" => "Burger2Controller"
        ]);
    }

    #[Route('/burger2/top', name: 'burger2_top')]
    private function top(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findTopXBurgers(5);
        return $this->render('burger2/index.html.twig', [
            'burgers' => $burgers,
            "controller_name" => "Burger2Controller"
        ]);
    }
    #[Route('/burger2/without', name: 'burger2_without')]
    private function withoutIngredients(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findBurgersWithoutIngredient("Oignon");
        return $this->render('burger2/index.html.twig', [
            'burgers' => $burgers,
            "controller_name" => "Burger2Controller"
        ]);
    }


    #[Route('/burger2/with', name: 'burger2_with')]
    private function withSomeIngredients(BurgerRepository $burgerRepository): Response{
        $burgers = $burgerRepository->findBurgersWithMinimumIngredients(2);
        return $this->render('burger2/index.html.twig', [
            'burgers' => $burgers,
            "controller_name" => "Burger2Controller"
        ]);
    }

    #[Route('burger2/new', name: 'burger2_add',methods: ['POST','GET'])]
    public function addBurger(Request $request, EntityManagerInterface $em): Response{
        $burger = new Burger();
        $form=$this->createForm(BurgerType::class,$burger);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($burger);
            $em->flush();

            $this->addFlash("success","Le burger a bien été ajouté");
            return $this->redirectToRoute("app_burger2");
        }

        return $this->render("burger2/new.html.twig",[
            "controller_name"=>"Burger2Controller",
            "form"=>$form->createView()
        ]);
    }

}
