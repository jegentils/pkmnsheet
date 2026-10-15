<?php

namespace App\Tests\Controller;

use App\Entity\Dresseur;
use App\Entity\Pkmn;
use App\Entity\User;
use App\Repository\DresseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DresseurControllerTest extends WebTestCase
{
    public function testOnlyTheAuthenticatedUsersDresseursAreListed(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $owner = (new User())
            ->setEmail(uniqid('owner-', true).'@example.test')
            ->setPassword('not-used-in-this-test');
        $otherUser = (new User())
            ->setEmail(uniqid('other-', true).'@example.test')
            ->setPassword('not-used-in-this-test');

        $ownerTrainer = (new Dresseur())
            ->setUser($owner)
            ->setName('Sacha')
            ->setLastname('Ketchum');
        $secondOwnerTrainer = (new Dresseur())
            ->setUser($owner)
            ->setName('Aurore')
            ->setLastname('Plume');
        $otherTrainer = (new Dresseur())
            ->setUser($otherUser)
            ->setName('Dresseur')
            ->setLastname('Secret');
        $teamPokemon = (new Pkmn())
            ->setDresseur($ownerTrainer)
            ->setName('Pikachu')
            ->setNumber(25);
        $caughtPokemon = (new Pkmn())
            ->setDresseur($ownerTrainer)
            ->setName('Carapuce')
            ->setNumber(7);
        $otherPokemon = (new Pkmn())
            ->setDresseur($otherTrainer)
            ->setName('Mewtwo')
            ->setNumber(150);

        $entityManager->persist($owner);
        $entityManager->persist($otherUser);
        $entityManager->persist($ownerTrainer);
        $entityManager->persist($secondOwnerTrainer);
        $entityManager->persist($otherTrainer);
        $entityManager->persist($teamPokemon);
        $entityManager->persist($caughtPokemon);
        $entityManager->persist($otherPokemon);
        $entityManager->flush();
        $ownerTrainer->setPkmn1Id($teamPokemon->getId());
        $entityManager->flush();

        $entityManager->clear();
        $client->loginUser($entityManager->getRepository(User::class)->find($owner->getId()));
        $client->request('GET', '/dresseurs');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Mes dresseurs');
        self::assertSelectorTextContains('main', 'Sacha Ketchum');
        self::assertSelectorTextContains('main', 'Aurore Plume');
        self::assertSelectorTextNotContains('main', 'Dresseur Secret');
        self::assertSelectorTextContains('main', 'Équipe actuelle');
        self::assertSelectorTextContains('main', '#25 Pikachu');
        self::assertSelectorTextContains('main', 'Tous les Pokémon attrapés (2)');
        self::assertSelectorTextContains('main', '#7 Carapuce');
        self::assertSelectorTextNotContains('main', 'Mewtwo');
    }

    public function testAnonymousVisitorIsRedirectedToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/dresseurs');

        self::assertResponseRedirects('/login');
    }

    public function testAuthenticatedUserCanCreateTheirOwnDresseur(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $user = (new User())
            ->setEmail(uniqid('creator-', true).'@example.test')
            ->setPassword('not-used-in-this-test');

        $entityManager->persist($user);
        $entityManager->flush();
        $client->loginUser($user);

        $crawler = $client->request('GET', '/dresseurs/nouveau');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Créer un dresseur');

        $form = $crawler->selectButton('Créer le dresseur')->form([
            'dresseur[name]' => 'Ondine',
            'dresseur[lastname]' => 'Senshi',
            'dresseur[genre]' => 'F',
            'dresseur[str]' => 5,
            'dresseur[dex]' => 4,
            'dresseur[con]' => 3,
            'dresseur[end]' => 2,
            'dresseur[vol]' => 1,
        ]);
        $client->submit($form);

        self::assertResponseRedirects('/dresseurs');
        $client->followRedirect();
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('main', 'Ondine Senshi');

        $dresseurs = static::getContainer()
            ->get(DresseurRepository::class)
            ->findAllForUser($user);
        self::assertCount(1, $dresseurs);
        self::assertSame('F', $dresseurs[0]->getGenre());
        self::assertSame($user->getId(), $dresseurs[0]->getUser()?->getId());
        self::assertSame([5, 4, 3, 2, 1], [
            $dresseurs[0]->getStr(),
            $dresseurs[0]->getDex(),
            $dresseurs[0]->getCon(),
            $dresseurs[0]->getEnd(),
            $dresseurs[0]->getVol(),
        ]);
    }

    public function testDresseurCreationRejectsInvalidStatAllocation(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $user = (new User())
            ->setEmail(uniqid('invalid-creator-', true).'@example.test')
            ->setPassword('not-used-in-this-test');

        $entityManager->persist($user);
        $entityManager->flush();
        $client->loginUser($user);

        $crawler = $client->request('GET', '/dresseurs/nouveau');
        $form = $crawler->selectButton('Créer le dresseur')->form([
            'dresseur[name]' => 'Ondine',
            'dresseur[lastname]' => 'Senshi',
            'dresseur[str]' => 4,
            'dresseur[dex]' => 4,
            'dresseur[con]' => 4,
            'dresseur[end]' => 1,
            'dresseur[vol]' => 1,
        ]);
        $client->submit($form);

        self::assertResponseStatusCodeSame(422);
        self::assertSelectorTextContains('main', 'Les cinq statistiques doivent totaliser exactement 15 points.');
        self::assertCount(0, static::getContainer()->get(DresseurRepository::class)->findAllForUser($user));

        $crawler = $client->request('GET', '/dresseurs/nouveau');
        $form = $crawler->selectButton('Créer le dresseur')->form([
            'dresseur[name]' => 'Ondine',
            'dresseur[lastname]' => 'Senshi',
            'dresseur[str]' => 6,
            'dresseur[dex]' => 3,
            'dresseur[con]' => 3,
            'dresseur[end]' => 2,
            'dresseur[vol]' => 1,
        ]);
        $client->submit($form);

        self::assertResponseStatusCodeSame(422);
        self::assertSelectorTextContains('main', 'La force doit être comprise entre 1 et 5.');
        self::assertCount(0, static::getContainer()->get(DresseurRepository::class)->findAllForUser($user));
    }
}
