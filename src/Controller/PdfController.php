<?php

namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PdfRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Pdf;
use App\Entity\User;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use App\Entity\Subscription;

class PdfController extends AbstractController
{
    private GotenbergService $gotenbergService;
    private EntityManagerInterface $entityManager;
    private PdfRepository $pdfRepository;

    public function __construct(GotenbergService $gotenbergService, EntityManagerInterface $entityManager, PDFRepository $pdfRepository)
    {
        $this->gotenbergService = $gotenbergService;
        $this->entityManager = $entityManager;
        $this->pdfRepository = $pdfRepository;
    }

    #[Route('/pdf', name: 'app_pdf')]
    public function index(): Response
    {
        $startOfDay = new \DateTime('today');
        $endOfDay = new \DateTime('tomorrow');
        $pdfCountToday = $this->pdfRepository->countPdfGeneratedByUserOnDate($this->getUser()->getId(), $startOfDay, $endOfDay);

        $pdfLimitExceeded = $pdfCountToday >= $this->getUser()->getSubscription()->getPdfLimit();

        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
            'pdf_limit_exceeded' => $pdfLimitExceeded,
        ]);
    }


    #[Route('/pdf/convert', name: 'app_pdf_convert', methods: ['POST'])]
    public function convert(Request $request, EntityManagerInterface $entityManager): Response{$url = $request->request->get('url');

        $pdfFilePath = $this->gotenbergService->generatePdfFromUrl($url);
        $pdfTitle = 'Pdf';

        $pdf = new Pdf();
        $pdf->setUserId($this->getUser());
        $pdf->setTitle($pdfTitle);
        $pdf->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($pdf);
        $entityManager->flush();

        return $this->file($pdfFilePath);
    }

}
