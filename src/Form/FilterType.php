<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         
        ->add('destinataire', ChoiceType::class, [
            'choices' => [
                'Service client' => 'Service client',
                'Service technique' => 'Service technique',
                'Service commercial' => 'Service commercial',
            ],
            'placeholder' => 'Choose an option',
            'required' => true,
            'data' => 'Service commercial', // add a default value here
        ])
        ->add('filter',SubmitType::class);
            
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        
        ]);
    }
}
