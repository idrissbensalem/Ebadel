<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('produit_propose')
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Téléphonie et tablette' => 'Téléphonie et tablette',
                    'Informatique' => 'Informatique',
                    'Voitures' => 'Voitures',
                    'Mode' => 'Mode',
                    'Mode et beauté' => 'Mode et beauté',
                ],
                'placeholder' => 'Sélectionner la catégorie de la produit proposé',
                'required' => true,
            ])
            ->add('sous_categorie', ChoiceType::class, [
                'choices' => [
                    'Smartphone' => 'Smartphone',
                    'Iphone' => 'Iphone',
                    'iPad' => 'iPad',
                    'les voitures de sport' => 'les voitures de sport'
                ],
                'placeholder' => 'Sélectionner la sous catégorie de la produit proposé',
                'required' => true,
            ])
            ->add('marque', ChoiceType::class, [
                'choices' => [
                    'Samsung' => 'Samsung',
                    'Xiaomi ' => 'Xiaomi ',
                    'Sony' => 'Sony',
                    'Apple' => 'Apple',
                    'Peugeot' => 'Peugeot',
                ],
                'placeholder' => 'Sélectionner la marque de la produit proposé',
                'required' => true,
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