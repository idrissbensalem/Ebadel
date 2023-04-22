<?php

namespace App\Form;

use App\Entity\Souscategorie;
use App\Entity\Categorie;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;


class SousCategorieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomC', EntityType::class, [
                'label' => 'Categorie',
                'class' => Categorie::class,
                'choice_label' => 'nomC',
                'placeholder' => 'Selectionnez une catégorie',
                'attr' => [
                    
                    'class' => 'form-control animate__animated animate__fadeInDown',
                ], 'constraints'=>[
                    new Assert\Valid(),
                ],

            ])
            ->add('nom_s_c', TextType::class, [
                'label' => 'Sous catégorie ',
                'attr' => [
                    'placeholder' => 'La nouvelle sous catégorie',
                    'class' => 'form-control animate__animated animate__fadeInDown',
                ], 'constraints'=>[
                    new Assert\Valid(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-primary animate__animated animate__fadeInUp',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Souscategorie::class,
        ]);
    }
}




