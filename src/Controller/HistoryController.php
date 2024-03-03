<?php

// src/Controller/HistoryController.php

namespace App\Controller;

use App\Repository\PdfRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history')]
    public function index(PdfRepository $pdfRepository): Response
    {
        $user = $this->getUser();

        $pdfs = $pdfRepository->findBy(['userId' => $user]);

        return $this->render('history/index.html.twig', [
            'pdfs' => $pdfs,
        ]);
    }
}

