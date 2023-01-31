<?php
// src/Controller/MailController.php
namespace App\Controller;

use App\Service\MailReceiver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    #[Route('/mails')]
    public function index(MailReceiver $mailReceiver): Response
    {

        return $this->render('mails.html.twig', [
            'messages' => $mailReceiver->getMails(),
        ]);
    }


}
