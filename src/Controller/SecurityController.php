<?php

namespace App\Controller;


use App\Entity\User;

use App\Form\LoginType;
use App\Form\InscriptionType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Security\LoginFormAuthenticator;

class SecurityController extends AbstractController
{
   /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface  $encoder)
     {
    $user = new User();
    $form = $this->createForm(InscriptionType::class,$user);
    $form->handleRequest($request);
if($form->isSubmitted() && $form->isValid()) {


   $em=$this->getDoctrine()->getRepository(User::class);
   $email = $user->getEmail();
   echo "<script > console.log('$email')</script>";
   $VarName = $em->findOneBy(['email'=>$email]);
   if( is_null($VarName)){
    $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
    $user->setPassword($hash);
             
    $manager->persist($user);
    $manager->flush();
    return $this->redirectToRoute('security_login');
   }else{
    echo "<script > console.log('email est deja utilise')</script>";
    echo "<script > alert('email est deja utilise')</script>";
   }


 

}


    return $this->render('security/registration.html.twig', [
        'form' => $form->createView()
    ]);
}


    /**
     * @Route("/login", name="security_login")
     */
    public function login(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface  $encoder,Session  $session, GuardAuthenticatorHandler $handler,
   )
    {         echo "<script> console.log('TEST')</script>";
        $ok=false;
        $user = new User();
        $form = $this->createForm(LoginType::class,$user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            echo "<script > console.log('sssssssssss')</script>";
            
            $email = $user->getEmail();
           
    
            $em=$this->getDoctrine()->getRepository(User::class);
            $VarName = $em->findOneBy(['email'=>$email]);
                $Role=$user->getRole();
                echo "<script > console.log('$email')</script>";
       
                if( is_null($VarName)) {
                    echo "<script >  console.log('fergha')</script>";
                        
                  return $this->redirectToRoute('security_login');
                          
                    }  else{
                        $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
                       # $encoded = $encoder->encodePassword($user,$user->getPassword());
                        $pass=$VarName->getPassword();
                   $pass1= $user->getPassword();
                   
                  
                   echo "<script >  console.log( '$hash')</script>";
                    if (password_verify($user->getPassword(),$VarName->getPassword())) {
                        echo "<script >  console.log('shiha')</script>";
               

                        // stores an attribute in the session for later reuse
                        $session->set('email', $email);

                        if($VarName->getRole()==0){

                            return $this->redirectToRoute('',['session'=>$session]);
                        }
                        else{
                            return $this->redirectToRoute('',['session'=>$session]);
                        }
                  
                        /*echo "<script >localStorage.setItem('email', '$email');</script>";
                        echo "<script >localStorage.setItem('Role', '$Role');</script>";    
                      
                          echo "<script >localStorage.setItem('email', '$email');</script>";
                          echo "<script >localStorage.setItem('Role', '$Role');</script>";    */
    
                    } else {
                        echo "<script >  console.log('ghalta')</script>";
                            return $this->redirectToRoute('security_login');
                    }
     
                    }
                }
            
return $this->render('security/login.html.twig', [
    'form' => $form->createView()
]);
    }
      /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
 
        return $this->redirectToRoute('security_login');
    }
}