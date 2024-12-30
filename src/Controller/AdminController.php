<?php

namespace App\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CardType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function index(
        CardRepository $cardRepository,
        UserRepository $userRepository,
        ChartBuilderInterface $chartBuilder
    ): Response {
        $cards = $cardRepository->findAll();
        $totalCards = count($cards);
        $activeUsers = count($userRepository->findAll());

        $typeChart = $chartBuilder->createChart(Chart::TYPE_PIE);
        $typeChart->setData([
            'labels' => array_column($cardRepository->countByType(), 'type'),
            'datasets' => [
                [
                    'data' => array_column($cardRepository->countByType(), 'count'),
                    'backgroundColor' => ['#FFA500', '#4FC3F7'],
                    'borderWidth' => 0,
                ]
            ]
        ]);
        $typeChart->setOptions([
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'color' => '#FFD700',
                        'font' => ['size' => 12]
                    ]
                ]
            ],
            'maintainAspectRatio' => true,
            'responsive' => true
        ]);

        $classChart = $chartBuilder->createChart(Chart::TYPE_PIE);
        $classChart->setData([
            'labels' => array_column($cardRepository->countByClass(), 'class'),
            'datasets' => [
                [
                    'data' => array_column($cardRepository->countByClass(), 'count'),
                    'backgroundColor' => [
                        '#4A148C',
                        '#FFD700',
                        '#FFA500',
                        '#4FC3F7',
                        '#111827'
                    ],
                    'borderWidth' => 0,
                ]
            ]
        ]);
        $classChart->setOptions([
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'color' => '#FFD700',
                        'font' => ['size' => 12]
                    ]
                ]
            ],
            'maintainAspectRatio' => true,
            'responsive' => true
        ]);

        return $this->render('admin/dashboard.html.twig', [
            'totalCards' => $totalCards,
            'activeUsers' => $activeUsers,
            'typeChart' => $typeChart,
            'classChart' => $classChart,
            'cards' => $cards,
        ]);
    }

    #[Route('/cards', name: 'app_admin_cards')]
    public function listCards(CardRepository $cardRepository): Response
    {
        return $this->render('admin/cards.html.twig', [
            'cards' => $cardRepository->findAll(),
        ]);
    }

    #[Route('/cards/{id}/delete', name: 'app_admin_delete_card', methods: ['POST'])]
    public function deleteCard(
        Request $request,
        Card $card,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $card->getId(), $request->request->get('_token'))) {
            $entityManager->remove($card);
            $entityManager->flush();
            $this->addFlash('success', 'Card successfully deleted.');
        }

        return $this->redirectToRoute('app_admin_dashboard');
    }

    #[Route('/cards/{id}/edit', name: 'app_admin_edit_card', methods: ['GET', 'POST'])]
    public function editCard(
        Request $request,
        Card $card,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Card successfully updated.');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        return $this->render('admin/edit_card.html.twig', [
            'card' => $card,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cards/{id}', name: 'app_admin_view_card', methods: ['GET'])]
    public function viewCard(Card $card): Response
    {
        return $this->render('admin/view_card.html.twig', [
            'card' => $card,
        ]);
    }
}
