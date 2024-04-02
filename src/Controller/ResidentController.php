<?php

namespace App\Controller;

use App\Entity\Resident;
use App\Form\ResidentType;
use App\Repository\ResidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/resident')]
class ResidentController extends AbstractController
{
    private const SIMPSONS_QUOTE_API_ENDPOINT = 'https://thesimpsonsquoteapi.glitch.me/quotes';

    #[Route('/', name: 'resident_index', methods: ['GET'])]
    public function index(ResidentRepository $residentRepository): Response
    {
        return $this->render('resident/index.html.twig', [
            'residents' => $residentRepository->getResidents()
        ]);
    }

    #[Route('/view/{id}', name: 'resident_view', requirements: ['id' => Requirement::POSITIVE_INT], methods: ['GET'])]
    public function view(Request $request, ResidentRepository $residentRepository): Response
    {
        $residentId = $request->get('id');
        return $this->render('resident/view.html.twig', [
            'resident' => $residentRepository->findResidentById($residentId),
        ]);
    }

    #[Route('/add', name: 'resident_add', methods: ['GET', 'POST'])]
    public function add(Request $request, ResidentRepository $residentRepository): Response
    {
        $resident = new Resident();
        $resident->setId($residentRepository->getNextAvailableId());

        $form = $this->createForm(ResidentType::class, $resident);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $residentRepository->add($form->getData());
            $this->addFlash('success', 'Resident created successfully.');

            return $this->redirectToRoute('resident_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('resident/add.html.twig', [
            'resident' => $resident,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'resident_edit', requirements: ['id' => Requirement::POSITIVE_INT], methods: ['GET', 'POST'])]
    public function edit(Request $request, ResidentRepository $residentRepository): Response
    {
        $resident = $residentRepository->findResidentById($request->get('id'));

        $form = $this->createForm(ResidentType::class, $resident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $residentRepository->update($form->getData());
            $this->addFlash('success', 'Resident updated successfully.');

            return $this->redirectToRoute('resident_edit', ['id' => $resident->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('resident/edit.html.twig', [
            'resident' => $resident,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'resident_delete', requirements: ['id' => Requirement::POSITIVE_INT], methods: ['POST', 'GET'])]
    public function delete(Request $request, ResidentRepository $residentRepository): Response
    {
        $isSuccess = $residentRepository->delete($request->get('id'));
        if ($isSuccess) {
            $this->addFlash('success', 'Resident deleted successfully.');
        } else {
            $this->addFlash('warning', 'Resident could not be deleted.');
        }

        return $this->redirectToRoute('resident_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/lookup/{ch}/{count}', name: 'quote_lookup', requirements: ['count' => Requirement::POSITIVE_INT], methods: ['GET'])]
    public function lookupQuote(Request $request, HttpClientInterface $client): Response
    {
        $queryParams = [
            'character' => $request->get('ch'),
            'count' => $request->get('count')
        ];
        $queryString = http_build_query($queryParams);

        $response = $client->request('GET', self::SIMPSONS_QUOTE_API_ENDPOINT . '?' . $queryString);

        $quotes = [];
        $isSuccess = true;
        if ($response->getStatusCode() === Response::HTTP_OK) {
            $quotes = json_decode($response->getContent(), true);
        } else {
            $isSuccess = false;
        }
        return $this->render('resident/quotes.html.twig', [
            'quotes' => $quotes,
            'isSuccess' => $isSuccess,
        ]);
    }
}