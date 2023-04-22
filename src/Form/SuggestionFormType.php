<?php

namespace App\Form;

use App\Entity\Suggestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SuggestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('suggC', TextType::class, [
            'label' => 'Suggestion pour une catégorie',
            'attr' => [
                'placeholder' => 'Nouvelle catégorie',
                'class' => 'form-control',
            ]
        ])
        ->add('suggS', TextType::class, [
            'label' => 'Suggestion pour une sous-catégorie',
            'attr' => [
                'placeholder' => 'Nouvelle sous-catégorie',
                'class' => 'form-control',
            ]
        ])
        ->add('suggM', TextType::class, [
            'label' => 'Suggestion pour une marque',
            'attr' => [
                'placeholder' => 'Nouvelle marque',
                'class' => 'form-control',
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Suggestion::class,
        ]);
    }
}
