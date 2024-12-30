<?php

namespace App\Controller;

use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/cards', name: 'api_cards', methods: ['GET'])]
    public function getCards(CardRepository $cardRepository): JsonResponse
    {
        $cards = $cardRepository->findAll();

        $data = [];
        foreach ($cards as $card) {
            $data[] = [
                'id' => $card->getId(),
                'name' => $card->getName(),
                'type' => $card->getType(),
                'class' => $card->getClass(),
                'attackPower' => $card->getAttackPower(),
                'creator' => $card->getUser()->getEmail(),
                'image' => $card->getImageName() ? '/images/cards/' . $card->getImageName() : null,
            ];
        }

        return $this->json($data);
    }
}
