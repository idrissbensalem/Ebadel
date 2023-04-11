<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('cin',  TextType::class,[
            'required' => true,
        ])
        ->add('nom',  TextType::class,[
            'required' => true,
        ])
        ->add('prenom',  TextType::class,[
            'required' => true,
        ])
        ->add('tel',  TextType::class,[
            'required' => true,
        ])
        ->add('email',EmailType::class,[
            'required' => true,
        ])
        ->add('password', PasswordType::class, [
            'required' => true,
        ])
        ->add('imageFile',VichImageType::class,[
            'required' => true,
        ])
      
        ->add('datenaissance',DateType::class, [
            // renders it as a single text box
            'required' => true,
            'widget' => 'single_text',
        ])
            ;}
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
