<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    /**
     * @Route("/compte/modifier-mdp", name="account_password")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification=null;
        $user = $this->getUser();
        $form =$this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $old_password = $form->get('old_password')->getData();

            if ($encoder->isPasswordValid($user,$old_password)){
                $new_password = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user,$new_password);
                $user->setPassword($password);
                $this->manager = $this->getDoctrine()->getManager();
                $this->manager->flush();
                $notification = "Votre mot de passe a bien été mis à jour!";
            }else{
                $notification = "Votre mot de passe n'a pas été mis à jour";
            }

        }

        

        return $this->render('account/password.html.twig', [
            'form'=>$form->createView(),
            'notification'=>$notification
        ]);
    }
}
