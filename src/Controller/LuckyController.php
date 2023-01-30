<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number')]
    public function number(LoggerInterface $logger): Response
    {
        $number = random_int(0, 100);
        $logger->info("Number: {$number}");

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }
}
