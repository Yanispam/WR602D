<?php
// tests/Entity/SubscriptionTest.php
namespace App\Tests\Entity;

use App\Entity\Subscription;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité Subscription
        $subscription = new Subscription();

        // Définition de données de test
        $price = 10.5;
        $title = 'Test';
        $description = 'Test';
        $pdfLimit = 10;
        $media = 'Test';


        // Utilisation des setters
        $subscription->setPrice($price);
        $subscription->setTitle($title);
        $subscription->setDescription($description);
        $subscription->setPdfLimit($pdfLimit);
        $subscription->setMedia($media);

        // Vérification des getters
        $this->assertEquals($price, $subscription->getPrice());
        $this->assertEquals($title, $subscription->getTitle());
        $this->assertEquals($description, $subscription->getDescription());
        $this->assertEquals($pdfLimit, $subscription->getPdfLimit());
        $this->assertEquals($media, $subscription->getMedia());
    }
}