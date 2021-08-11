<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager =$entityManager;
    }
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user =$form->getData();
            $password = $encoder->hashPassword($user,$user->getPassword());
            $user->setPassword($password);

            //$doctrine = $this->getDoctrine()->getManager();
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            #TODO  flash message
            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig',[
            'form'=>$form->createView(),

        ]);
    }
}
