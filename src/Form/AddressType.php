<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Quel nom souhaitez-vous donner à cette adresse?',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Saisissez le nom de cette adresse',
                    
                ]
            ])
            ->add('firstName',TextType::class,[
                'label'=>'Votre prénom',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Saisissez votre prénom',
                    
                ]
            ])
            ->add('lastName',TextType::class,[
                'label'=>'Votre nom',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Saisissez votre nom',
                    'required'=>true
                ]
            ])
            ->add('company',TextType::class,[
                'label'=>'Votre entreprise',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Saisissez votre entreprise', 
                ]
            ])
            ->add('address',TextType::class,[
                'label'=>'Votre adresse',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Saisissez votre adresse',
                  
                ]
            ])
            ->add('zipcode',TextType::class,[
                'label'=>'Votre code postal',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Saisissez votre postal',
                    
                ]
            ])
            ->add('city',TextType::class,[
                'label'=>'Votre ville',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Saisissez votre ville',
                ]
            ])
            ->add('country',CountryType::class,[
                'label'=>'Votre pays',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Saisissez votre pays'
                ]
            ])
            ->add('phone',TelType::class,[
                'label'=>'Votre numéro de téléphone',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Saisissez votre numéro de téléphone'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Valider mon adresse',
                'attr'=>[
                    'class'=>'btn btn-block btn-info'
                ]
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
