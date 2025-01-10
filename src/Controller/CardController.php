<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardEditType;
use App\Form\CardType;
use App\Repository\CardRepository;
use App\Service\CardNameGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/member/card')]
class CardController extends AbstractController
{
    private $nameGenerator;

    public function __construct(CardNameGenerator $nameGenerator)
    {
        $this->nameGenerator = $nameGenerator;
    }

    #[Route('/', name: 'app_card_index', methods: ['GET'])]
    public function index(CardRepository $cardRepository): Response
    {
        $user = $this->getUser();
        $cards = $cardRepository->findBy(['user' => $user]);

        return $this->render('card/index.html.twig', [
            'cards' => $cards,
        ]);
    }

    #[Route('/new', name: 'app_card_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $card = new Card();
        $card->setUser($this->getUser());


        $card->setName($this->nameGenerator->generateName());

        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $existingCard = $entityManager->getRepository(Card::class)->findOneBy(['name' => $card->getName()]);
            while ($existingCard !== null) {
                $card->setName($this->nameGenerator->generateName());
                $existingCard = $entityManager->getRepository(Card::class)->findOneBy(['name' => $card->getName()]);
            }

            $entityManager->persist($card);
            $entityManager->flush();

            $this->addFlash('success', 'Card created successfully with name: ' . $card->getName());
            return $this->redirectToRoute('app_card_index');
        }

        return $this->render('card/new.html.twig', [
            'card' => $card,
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/{id}', name: 'app_card_show', methods: ['GET'])]
    // public function show(Card $card): Response
    // {
    //     if ($this->getUser() !== $card->getUser() && !$this->isGranted('ROLE_ADMIN')) {
    //         throw $this->createAccessDeniedException('You can only view your own cards.');
    //     }

    //     return $this->render('card/show.html.twig', [
    //         'card' => $card,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_card_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Card $card, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() !== $card->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You can only edit your own cards.');
        }

        $form = $this->createForm(CardEditType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Card updated successfully.');
            return $this->redirectToRoute('app_card_index');
        }

        return $this->render('card/edit.html.twig', [
            'card' => $card,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_card_delete', methods: ['POST'])]
    public function delete(Request $request, Card $card, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() !== $card->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You can only delete your own cards.');
        }

        if ($this->isCsrfTokenValid('delete' . $card->getId(), $request->request->get('_token'))) {
            $entityManager->remove($card);
            $entityManager->flush();
            $this->addFlash('success', 'Card deleted successfully.');
        }

        return $this->redirectToRoute('app_card_index');
    }
}
