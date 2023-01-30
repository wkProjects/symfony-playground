<?php
// src/Controller/HappyController.php
namespace App\Controller;

use App\Service\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HappyController extends AbstractController
{
    #[Route('/happy')]
    public function index(MessageGenerator $messageGenerator): Response
    {

        return $this->render('happy.html.twig', [
            'message' => $messageGenerator->getHappyMessage(),
        ]);
    }
}
