<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    
    }
    public function load(ObjectManager $manager ): void
    {
        $user = new User();
         $user->setEmail('xx@gmail.com');
        $user->setPassword(
            $this->encoder->encodePassword($user,0000)
        );
        $user->setCin(12345688);
        $user->setImage("tt");
        $user->setNom("tt");
        $user->setPrenom('ee');
        $date = new \DateTime("12-12-2020");
        $user->setTel(55862);
        $user->setDatenaissance( $date );

        $manager->persist($user);
        $manager->flush();
    }
}
