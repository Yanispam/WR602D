<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Subscription;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    $subscription = new Subscription();
    $subscription->setTitle('Free');
    $subscription->setDescription('Free subscription');
    $subscription->setPrice(0);
    $subscription->setMedia('/images/free.png');
    $subscription->setPdfLimit(3);
    $manager->persist($subscription);

    $subscription = new Subscription();
    $subscription->setTitle('Basic');
    $subscription->setDescription('Basic subscription');
    $subscription->setPrice(4.99);
    $subscription->setMedia('/images/basic.png');
    $subscription->setPdfLimit(6);
    $manager->persist($subscription);

    $subscription = new Subscription();
    $subscription->setTitle('Premium');
    $subscription->setDescription('Premium subscription');
    $subscription->setPrice(9.99);
    $subscription->setMedia('/images/premium.png');
    $subscription->setPdfLimit(9);
    $manager->persist($subscription);
    $manager->flush();
    }
}
