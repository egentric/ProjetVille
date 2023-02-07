<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/contact', name: 'app_main')]
    public function contact(): Response
     { 
        return $this->render('main/contact.html.twig', [ 
            'contact_param' => 'Salut les amis!', 
        ]); }
}
