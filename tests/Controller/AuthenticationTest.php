<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuthenticationTest extends WebTestCase
{
    public function testUserCanRegisterLoginAndAccessAccount(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $entityManager->createQuery('DELETE FROM App\Entity\User')->execute();

        $crawler = $client->request('GET', '/account');
        self::assertResponseRedirects('/login');

        $crawler = $client->followRedirect();
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Connexion');
        self::assertSelectorTextContains('.sidebar-intro', 'Ravi de te revoir !');

        $crawler = $client->clickLink('Créer un compte');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('.sidebar-intro', 'Prépare ta prochaine aventure');

        $form = $crawler->selectButton('Créer mon compte')->form([
            'registration_form[email]' => 'trainer@example.test',
            'registration_form[plainPassword][first]' => 'secure-password-123',
            'registration_form[plainPassword][second]' => 'secure-password-123',
        ]);
        $client->submit($form);

        self::assertResponseRedirects('/login');
        $crawler = $client->followRedirect();
        self::assertSelectorTextContains('[role="status"]', 'Votre compte est créé');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'trainer@example.test',
            '_password' => 'secure-password-123',
        ]);
        $client->submit($form);

        self::assertResponseRedirects('/account');
        $client->followRedirect();
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Mon compte');
        self::assertSelectorTextContains('main', 'trainer@example.test');

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'trainer@example.test']);
        self::assertNotNull($user);
        self::assertNotSame('secure-password-123', $user->getPassword());
    }
}
