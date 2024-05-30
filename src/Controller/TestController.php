<?php

namespace App\Controller;

use App\Entity\Price;
use App\Repository\ResidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/', name: 'test_index', methods: ['GET'])]
    public function index(ResidentRepository $residentRepository): Response
    {
        $price = new Price();
        $prices = [7,1,5,3,6,4];
        $maxProfit = $price->maxProfit($prices);
        print_r($maxProfit);
        return $this->render('test/index.html.twig', [
            'result' => ''
        ]);
    }

    #[Route('/max-profit', name: 'test_max_profit', methods: ['GET'])]
    public function maxProfit(ResidentRepository $residentRepository): Response
    {
        $price = new Price();
        $prices = [7,1,5,3,6,4];
        $maxProfit = $price->maxProfit($prices);
        print_r($maxProfit);
        return $this->render('test/index.html.twig', [
            'result' => ''
        ]);
    }
}