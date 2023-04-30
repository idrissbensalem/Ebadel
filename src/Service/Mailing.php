<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailing {


    public function __construct(private MailerInterface $mail)
    {
        
    }

    public function sendEmail(
        $content ='<p>See Twig integration for better HTML integration!</p>'
    ): void
    {
        $email = (new Email())
            ->from('ahmed.chouchene@esprit.tn')
            ->to('hassen.messsaoudi@esprit.tn')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Réclamation!')
            ->html($content);
            

        $this ->mail->send($email);

        // ...
    }


}