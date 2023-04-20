<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmsMessageController extends AbstractController
{
    #[Route('/sms/message', name: 'app_sms_message')]
    public function index(): Response
    {
        return $this->render('sms_message/index.html.twig', [
            'controller_name' => 'SmsMessageController',
        ]);
    }
}
