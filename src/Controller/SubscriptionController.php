<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use App\Form\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/subscription', name: 'app_subscription')]
    public function index(UserInterface $user, SubscriptionRepository $subscriptionRepository, UserRepository $userRepository, Request $request): Response
    {
        $subscriptions = $subscriptionRepository->findAll();
        $users = $userRepository->findAll();

        // Handle form to update user subscription
        $form = $this->createForm(SubscriptionType::class, $user);
        $form->handleRequest($request);

        // Persist the changes if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        // Fetch active subscription of the user
        $activeSubscription = $user->getActiveSubscription(); // Assuming you have this method in your User entity

        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
            'subscriptions' => $subscriptions,
            'active_subscription' => $activeSubscription,
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }
    #[Route('/subscription/change', name: 'app_subscription_change')]
    public function updateSubscription(Request $request, SubscriptionRepository $subscriptionRepository): Response
    {
        // Get the subscription ID from the submitted form data
        $subscriptionId = $request->request->get('subscription_id');

        // Find the subscription entity based on the ID
        $subscription = $subscriptionRepository->find($subscriptionId);

        if (!$subscription) {
            throw $this->createNotFoundException('Subscription not found');
        }

        // Assuming you have a User entity and it's accessible via $this->getUser()
        $user = $this->getUser();

        // Update the user's subscription
        $user->setSubscription($subscription);

        // Persist changes
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Redirect back to the page where the form was submitted from
        return $this->redirectToRoute('app_subscription');
    }
}
