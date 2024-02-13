<?php
namespace App\Tests\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PdfControllerTest extends WebTestCase
{
    public function testGeneratePdf()
    {
        $client = static::createClient();

        $gotenbergService = self::$container->get(GotenbergService::class);

        $pdfContent = $gotenbergService->convertDocument('fichier/rapport.docx', 'pdf');

        $client->request('GET', '/pdf');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertEquals($pdfContent, $client->getResponse()->getContent());
    }
}
