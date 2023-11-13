<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Form\WeatherType;
use App\Repository\WeatherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/measurement')]
class MeasurementController extends AbstractController
{
    #[Route('/', name: 'app_measurement_index', methods: ['GET'])]
    #[IsGranted('ROLE_MEASUREMENT_INDEX')]
    public function index(WeatherRepository $weatherRepository): Response
    {
        return $this->render('measurement/index.html.twig', [
            'weather' => $weatherRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_measurement_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MEASUREMENT_NEW')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $weather = new Weather();
        $form = $this->createForm(WeatherType::class, $weather, [
            'validation_groups' => 'new',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($weather);
            $entityManager->flush();

            return $this->redirectToRoute('app_measurement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('measurement/new.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measurement_show', methods: ['GET'])]
    #[IsGranted('ROLE_MEASUREMENT_SHOW')]
    public function show(Weather $weather): Response
    {
        return $this->render('measurement/show.html.twig', [
            'weather' => $weather,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_measurement_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MEASUREMENT_EDIT')]
    public function edit(Request $request, Weather $weather, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WeatherType::class, $weather, [
            'validation_groups' => 'edit',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_measurement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('measurement/edit.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measurement_delete', methods: ['POST'])]
    #[IsGranted('ROLE_MEASUREMENT_DELETE')]
    public function delete(Request $request, Weather $weather, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weather->getId(), $request->request->get('_token'))) {
            $entityManager->remove($weather);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_measurement_index', [], Response::HTTP_SEE_OTHER);
    }
}
