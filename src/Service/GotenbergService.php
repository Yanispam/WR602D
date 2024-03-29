<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GotenbergService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function generatePdfFromUrl(string $url): string{

        $htmlContent = file_get_contents($url);

        $response = $this->httpClient->request(
            'POST',
            'http://localhost:3000/forms/chromium/convert/url',
            [
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                ],
                'body' => [
                    'url' => $url,
                ]
            ]);

        if ($response->getStatusCode() !== 200) {
            // Gérer l'erreur ici
            throw new \Exception('Failed to generate PDF from URL.');
        }

        // Récupérer le contenu du PDF généré
        $pdfContent = $response->getContent();

        // Sauvegarder le contenu dans un fichier PDF
        $pdfFilePath = sys_get_temp_dir() . '/' . uniqid('generated_pdf') . '.pdf';
        file_put_contents($pdfFilePath, $pdfContent);

        // Retourner le chemin du fichier PDF généré
        return $pdfFilePath;
    }
}
