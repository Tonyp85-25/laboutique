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
            $this->addFlash('success', "L' adresse a été créée!");
           return $this->redirectToRoute('account_address');

        }
        return $this->render('account/address_form.html.twig',[
            'form'=>$form->createView()
        ]);
    }

     /**
     * @Route("/compte/modifier-adresse/{id}", name="account_address_edit")
     */
    public function edit(Request $request, $id): Response
    {
        $address= $this->entityManager->getRepository(Address::class)->findOneBy(['id'=>$id]);
        if(!$address || $address->getCustomer() !== $this->getUser()){
            return $this->redirectToRoute('account_address');
        }

        $form=$this->createForm(AddressType::class,$address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
                 
            $this->entityManager->flush();
            $this->addFlash('success', "L' adresse a été modifiée!");
           return $this->redirectToRoute('account_address');

        }
        return $this->render('account/address_form.html.twig',[
            'form'=>$form->createView()
        ]);
    }

     /**
     * @Route("/compte/supprimer-adresse/{id}", name="account_address_delete")
     */
    public function delete(Request $request, $id): Response
    {
        $address= $this->entityManager->getRepository(Address::class)->findOneBy(['id'=>$id]);
        if($address && $address->getCustomer() == $this->getUser()){
            $this->entityManager->remove($address);
            $this->entityManager->flush();
            $this->addFlash('info', "L' adresse a été supprimée!");
        }

        return $this->redirectToRoute('account_address');
    }
}
