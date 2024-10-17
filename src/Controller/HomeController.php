<?php

namespace App\Controller;

use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CardRepository $cardRepository): Response
    {
        $latestCards = [];
        $userCards = [];

        if ($this->getUser()) {
            // Fetch cards for logged-in user
            $userCards = $cardRepository->findBy(['user' => $this->getUser()], ['id' => 'DESC'], 5);
        } else {
            // Fetch latest cards for guests
            $latestCards = $cardRepository->findLatestCards(5);
        }

        return $this->render('home/index.html.twig', [
            'latestCards' => $latestCards,
            'userCards' => $userCards,
        ]);
    }
}
