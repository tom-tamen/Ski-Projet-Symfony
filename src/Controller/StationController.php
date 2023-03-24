<?php

namespace App\Controller;

use App\Repository\StationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StationController extends AbstractController
{
    #[Route('/station/{id}', name: 'station_show')]
    public function index($id, StationRepository $stationRepository): Response
    {
        $station = $stationRepository->find($id);
        if(!$station) {
            throw $this->createNotFoundException('Station not found');
        }
        return $this->render('station/index.html.twig', [
            'station' => $station,
        ]);
    }
}
