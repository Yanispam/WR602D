<?php
// tests/Entity/UserTest.php
namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité User
        $user = new User();

        // Définition de données de test
        $email = 'test@test.com';
        $firstname = 'John';
        $lastname = 'Doe';
        $roles = ['ROLE_USER'];
        $password = 'password';
        $createdAt = new \DateTimeImmutable();
        $updatedAt = new \DateTime();
        $subscriptionEndAt = new \DateTime();

        // Utilisation des setters
        $user->setEmail($email);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setRoles($roles);
        $user->setPassword($password);
        $user->setCreatedAt($createdAt);
        $user->setUpdatedAt($updatedAt);
        $user->setSubscriptionEndAt($subscriptionEndAt);

        // Vérification des getters
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($firstname, $user->getFirstname());
        $this->assertEquals($lastname, $user->getLastname());
        $this->assertEquals($roles, $user->getRoles());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
        $this->assertEquals($subscriptionEndAt, $user->getSubscriptionEndAt());
    }
}