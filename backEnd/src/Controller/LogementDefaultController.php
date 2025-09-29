<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Logement;
use App\Repository\LogementRepository;

final class LogementDefaultController extends AbstractController
{
    #[Route('/logement/default', name: 'app_logement_default')]
    public function index(LogementRepository $logeRep): JsonResponse
    {

        $logements=$logeRep->findAll();
        return $this->json($logements);
    }
}
