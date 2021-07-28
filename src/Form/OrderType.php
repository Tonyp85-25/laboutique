<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user= $options['user'];
        $builder
            ->add('addresses', EntityType::class,[
                'label'=>'Choisissez votre adresse',
                'required'=>true,
                'class'=>Address::class,
                'multiple'=>false,
                'expanded'=>true,
                'choices'=>$user->getAddresses()


            ])
            ->add('carriers', EntityType::class,[
                'label'=>'Choisissez votre transporteur',
                'required'=>true,
                'class'=>Carrier::class,
                'multiple'=>false,
                'expanded'=>true,
                //'choices'=>$user->getAddresses()


            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'user'=>array()
        ]);
    }
}
