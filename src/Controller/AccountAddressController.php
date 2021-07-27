<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    /**
     * @Route("/compte/adresse", name="account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/compte/ajouer-adresse", name="account_address_add")
     */
    public function add(Request $request): Response
    {
        $address= new Address();
        $form=$this->createForm(AddressType::class,$address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $address->setCustomer($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            $this->redirectToRoute('account_address');

        }
        return $this->render('account/address_add.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
