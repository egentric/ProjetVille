<?php

namespace App\Controller;

use App\Entity\Agendas;
use App\Form\AgendasType;
use App\Repository\AgendasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/agendas')]
class AgendasController extends AbstractController
{
    #[Route('/', name: 'app_agendas_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]

    public function index(AgendasRepository $agendasRepository): Response
    {
        return $this->render('agendas/index.html.twig', [
            'agendas' => $agendasRepository->findAll(),
        ]);
    }

    #[Route('/agendasIndex', name: 'agendas_index', methods: ['GET'])]


    public function agendasIndex(AgendasRepository $agendasRepository): Response
    {
        return $this->render('agendas/agendasIndex.html.twig', [
            'agendas' => $agendasRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_agendas_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]

    public function new(Request $request, AgendasRepository $agendasRepository): Response
    {
        $agenda = new Agendas();
        $form = $this->createForm(AgendasType::class, $agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agendasRepository->save($agenda, true);

            return $this->redirectToRoute('app_agendas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agendas/new.html.twig', [
            'agenda' => $agenda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agendas_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]

    public function show(Agendas $agenda): Response
    {
        return $this->render('agendas/show.html.twig', [
            'agenda' => $agenda,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_agendas_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]

    public function edit(Request $request, Agendas $agenda, AgendasRepository $agendasRepository): Response
    {
        $form = $this->createForm(AgendasType::class, $agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agendasRepository->save($agenda, true);

            return $this->redirectToRoute('app_agendas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agendas/edit.html.twig', [
            'agenda' => $agenda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agendas_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]

    public function delete(Request $request, Agendas $agenda, AgendasRepository $agendasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agenda->getId(), $request->request->get('_token'))) {
            $agendasRepository->remove($agenda, true);
        }

        return $this->redirectToRoute('app_agendas_index', [], Response::HTTP_SEE_OTHER);
    }
}
