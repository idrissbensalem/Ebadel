<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_article')
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Téléphonie et tablette' => 'Téléphonie et tablette',
                    'Informatique' => 'Informatique',
                    'Voitures' => 'Voitures',
                    'Mode' => 'Mode',
                    'Mode et beauté' => 'Mode et beauté',
                ],
                'placeholder' => 'Sélectionner la catégorie de l\'article',
                'required' => true,
            ])
            ->add('sous_categorie', ChoiceType::class, [
                'choices' => [
                    'Smartphone' => 'Smartphone',
                    'Iphone' => 'Iphone',
                    'iPad' => 'iPad',
                    'les voitures de sport' => 'les voitures de sport'
                ],
                'placeholder' => 'Sélectionner la sous catégorie de l\'article',
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
                'placeholder' => 'Sélectionner la marque de l\'article',
                'required' => true,
            ])
            ->add('periode_utilisation')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Comme neuf' => 'Comme neuf',
                    'Très bon' => 'Très bon',
                    'Bon' => 'Bon',
                    'Correct' => 'Correct',
                ],
                'placeholder' => 'Sélectionner l\'état de l\'article',
                'required' => true,
            ])
            ->add('description')
            ->add('image', FileType::class, [
                'label' => 'L image de larticle ',

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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
    public function getSousCategories(string $categorie): array
{

    $sousCategories = [];

    switch ($categorie) {
        case 'Téléphonie et tablette':
            $sousCategories = [
                'Smartphone' => 'Smartphone',
                'Iphone' => 'Iphone',
                'iPad' => 'iPad',
            ];
            break;
        case 'Informatique':
            $sousCategories = [
                'Ordinateurs portables' => 'Ordinateurs portables',
                'Ordinateurs de bureau' => 'Ordinateurs de bureau',
                'Tablettes' => 'Tablettes',
            ];
            break;
        case 'Voitures':
            $sousCategories = [
                'Les voitures de sport' => 'Les voitures de sport',
                'Les SUVs' => 'Les SUVs',
                'Les camions' => 'Les camions',
            ];
            break;
        case 'Mode':
            $sousCategories = [
        'Vêtements pour hommes' => 'Vêtements pour hommes',
        'Vêtements pour femmes' => 'Vêtements pour femmes',
        'Chaussures' => 'Chaussures',
        'Accessoires' => 'Accessoires',
    ];
    break;
case 'Mode et beauté':
    $sousCategories = [
        'Soins du visage' => 'Soins du visage',
        'Soins du corps' => 'Soins du corps',
        'Maquillage' => 'Maquillage',
        'Parfums' => 'Parfums',
    ];
    break;
}

return $sousCategories;
}
}