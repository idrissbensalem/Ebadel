<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Marque;
use App\Entity\Offre;
use App\Entity\Souscategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('produit_propose')
            ->add('categorie', EntityType::class, [
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
            ->add('sous_categorie', EntityType::class, [
                'label' => 'Categorie',
                'class' => Souscategorie::class,
                'choice_label' => 'nom_s_c',
                'placeholder' => 'Selectionnez une sous catégorie',
                'attr' => [
                    
                    'class' => 'form-control animate__animated animate__fadeInDown',
                ], 'constraints'=>[
                    new Assert\Valid(),
                ],
            ])
            ->add('marque',EntityType::class, [
                'label' => 'Categorie',
                'class' => Marque::class,
                'choice_label' => 'nomM',
                'placeholder' => 'Selectionnez une marque',
                'attr' => [
                    
                    'class' => 'form-control animate__animated animate__fadeInDown',
                ], 'constraints'=>[
                    new Assert\Valid(),
                ],
            ])
            ->add('periode_utilisation')
            ->add('etat_produit_propose', ChoiceType::class, [
                'choices' => [
                    'Comme neuf' => 'Comme neuf',
                    'Très bon' => 'Très bon',
                    'Bon' => 'Bon',
                    'Correct' => 'Correct',
                ],
                'placeholder' => 'Sélectionner l\'état de la produit proposé',
                'required' => true,
            ])
            ->add('description')
            ->add('bonus')
            ->add('num_tel')
            ->add('image', FileType::class, [
              

                'mapped' => false,

                'required' => true,

                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid ImageFile',
                    ])
                ],
            ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}