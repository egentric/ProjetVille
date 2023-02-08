<?php

namespace App\Controller;

use App\Entity\History;
use App\Form\HistoryType;
use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/history')]
class HistoryController extends AbstractController
{
    #[Route('/', name: 'app_history_index', methods: ['GET'])]
    public function index(HistoryRepository $historyRepository): Response
    {
        return $this->render('history/index.html.twig', [
            'histories' => $historyRepository->findAll(),
        ]);
    }

    #[Route('/historyIndex', name: 'history_index', methods: ['GET'])]
    public function historyIndex(HistoryRepository $historyRepository): Response
    {
        return $this->render('history/historyIndex.html.twig', [
            'histories' => $historyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_history_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HistoryRepository $historyRepository): Response
    {
        $history = new History();
        $form = $this->createForm(HistoryType::class, $history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $historyRepository->save($history, true);

            return $this->redirectToRoute('app_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('history/new.html.twig', [
            'history' => $history,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_history_show', methods: ['GET'])]
    public function show(History $history): Response
    {
        return $this->render('history/show.html.twig', [
            'history' => $history,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_history_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, History $history, HistoryRepository $historyRepository): Response
    {
        $form = $this->createForm(HistoryType::class, $history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $historyRepository->save($history, true);

            return $this->redirectToRoute('app_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('history/edit.html.twig', [
            'history' => $history,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_history_delete', methods: ['POST'])]
    public function delete(Request $request, History $history, HistoryRepository $historyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$history->getId(), $request->request->get('_token'))) {
            $historyRepository->remove($history, true);
        }

        return $this->redirectToRoute('app_history_index', [], Response::HTTP_SEE_OTHER);
    }
}
