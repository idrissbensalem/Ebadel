<?php

namespace App\Form;

use App\Entity\Jeux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;

class JeuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type' , ChoiceType::class,array('choices'=> array(
                'Tirage au sort' => 'Tirage au sort' ,
                'Enchers en click' => 'Enchers en click' 
            ),
            'expanded' => false,
            'multiple'=> false,))
            ->add('titre')
            ->add('image', FileType::class, [
                'label' => 'L image de jeu ',

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
            ->add('date_debut')
            ->add('date_fin')
            ->add('produit')
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jeux::class,
        ]);
    }
}
