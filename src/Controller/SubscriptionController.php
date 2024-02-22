<?php

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Subscription;

class SubscriptionController extends AbstractController
{
    #[Route('/subscription', name: 'app_subscription')]
    public function index(SubscriptionRepository $subscriptionRepository, UserRepository $userRepository): Response
    {
        $subscriptions = $subscriptionRepository->findAll();
        $users = $userRepository->findAll();
        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
            'subscriptions' => $subscriptions,
            'users' => $users,
        ]);
    }
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }
    public function subscribe(Request $request): Response
    {
        // Récupérer l'ID de l'abonnement depuis la requête POST
        $subscriptionId = $request->request->get('subscriptionId');

        // Récupérer l'utilisateur connecté
        $user = $this->security->getUser();

        // Récupérer l'entité Subscription correspondant à l'ID
        $subscription = $this->entityManager->getRepository(Subscription::class)->find($subscriptionId);

        // Vérifier si l'utilisateur et l'abonnement existent
        if (!$user || !$subscription) {
            throw $this->createNotFoundException('Utilisateur ou abonnement non trouvé.');
        }

        // Mettre à jour l'ID d'abonnement pour l'utilisateur connecté
        $user->setSubscription($subscription);

        // Sauvegarder les changements dans la base de données
        $this->entityManager->flush();

        // Redirection ou réponse JSON selon les besoins
        return $this->redirectToRoute('app_subscription'); // Redirigez vers une autre page après la souscription
    }
}
