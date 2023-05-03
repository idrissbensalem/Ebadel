<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ReclamationType extends AbstractType
{

    
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {  

      
        $builder
           
        ->add('user', EntityType::class, [
            'class' => User::class,
            'query_builder' => function (UserRepository $er) {
                
                $user = $this->security->getUser();
                if ($user instanceof User && $user !== null) {
                    $qb = $er->createQueryBuilder('u');
                    $qb->where('u.id = :user_id')->setParameter('user_id', $user->getId());
                }
               
               
                return $qb;
            },
            'choice_label' => 'email'
        ])
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
            ->add('createdAt');
           
            $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();
                $badWords = [
                'bad service'];
    
               
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
