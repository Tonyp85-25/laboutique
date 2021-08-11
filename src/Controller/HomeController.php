<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SessionInterface $session): Response
    {
        $session->set('cart',[
            [
                'id'=>522,
                'quantity'=>12
            ]
            ]);
            $cart = $session->get('cart');
        return $this->render('home/index.html.twig'
           
        );
    }

    /**
     * @Route("/credits", name="credits")
     */
    public function credits(): Response
    {
        return $this->render('home/credits.html.twig'
           
        );
    }
}
