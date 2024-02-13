<?php

namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    private GotenbergService $gotenbergService;

    public function __construct(GotenbergService $gotenbergService)
    {
        $this->gotenbergService = $gotenbergService;
    }

    #[Route('/pdf', name: 'app_pdf')]
    public function index(): Response
    {
        return $this->render('pdf/index.html.twig');
    }


    #[Route('/pdf/convert', name: 'app_pdf_convert', methods: ['POST'])]
    public function convert(Request $request): Response{$url = $request->request->get('url');

        $pdfFilePath = $this->gotenbergService->generatePdfFromUrl($url);

        return $this->file($pdfFilePath);
    }

}
