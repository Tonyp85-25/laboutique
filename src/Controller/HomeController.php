<?php

namespace App\Controller;

use App\Entity\Header;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager =$entityManager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(SessionInterface $session): Response
    {
        $products=[];
        $products=$this->entityManager->getRepository(Product::class)->findBy(['isBest'=>true]);
        $headers = $this->entityManager->getRepository(Header::class)->findAll();
        $session->set('cart',[
            [
                'id'=>522,
                'quantity'=>12
            ]
            ]);
            $cart = $session->get('cart');
        return $this->render('home/index.html.twig',[
            'headers'=>$headers,
            'products'=> $products
        ]
           
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
