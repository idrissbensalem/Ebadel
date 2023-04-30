<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email' ])
            ->add('destinataire', ChoiceType::class, [
                'choices' => [
                    'Service client' => 'Service client',
                    'Service technique' => 'Service technique',
                    'Service commercial' => 'Service commercial',
                ],
                
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    
                    'Demande de renseignement' => 'Demande de renseignement',
                    'Demande de service' => 'Demande de service',
                    'Problème' => 'Problème',
                ],
                
            ])
          
            ->add('description')
            ->add('createdAt')
           
            ->add('envoyer',SubmitType::class);
            $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();
                $badWords = ['nigga',
                'nigger',
                'nig nog',
                'nimphomania',
                'nipple',
                'nipples',
                'mound of venus',
                'mr hands','honkey',
                
                'hot carl',
                'hot chick',
                'how to kill','bad service']; // Array of bad words
    
                // Check if the description contains any bad words
                foreach ($badWords as $badWord) {
                    if (strpos($data['description'], $badWord) !== false) {
                        $data['description'] = str_replace($badWord, '', $data['description']);
                    }
                }
    
                $event->setData($data);
            });
        }

    


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
