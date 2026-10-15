<?php

namespace App\Tests\Entity;

use App\Entity\Dresseur;
use App\Entity\Pkmn;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DresseurTest extends KernelTestCase
{
    public function testDresseurAndPokemonCanBePersistedWithTheirRelationship(): void
    {
        self::bootKernel();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $connection = $entityManager->getConnection();
        $connection->beginTransaction();

        try {
            $user = (new User())
                ->setEmail(uniqid('trainer-', true).'@example.test')
                ->setPassword('not-used-in-this-test');

            $dresseur = (new Dresseur())
                ->setUser($user)
                ->setGenre('F')
                ->setName('Sacha')
                ->setLastname('Ketchum')
                ->setStr(10)
                ->setDex(11)
                ->setCon(12)
                ->setEnd(13)
                ->setVol(14)
                ->setStrTemp(1)
                ->setDexTemp(2)
                ->setConTemp(3)
                ->setEndTemp(4)
                ->setVolTemp(5)
                ->setVitTemp(6)
                ->setMoney(500)
                ->setNature('Jovial')
                ->setXp(1000)
                ->setPkmn1Id(25);
            $pkmn = (new Pkmn())
                ->setDresseur($dresseur)
                ->setGenre('M')
                ->setName('Pikachu')
                ->setNumber(25)
                ->setIvStr(31)
                ->setEvDex(252)
                ->setVitTemp(10)
                ->setAffection(200)
                ->setNature('Jovial')
                ->setXp(1500)
                ->setHeldItem('Balle Lumière')
                ->setTalent('Statik');

            $entityManager->persist($user);
            $entityManager->persist($dresseur);
            $entityManager->persist($pkmn);
            $entityManager->flush();
            $entityManager->clear();

            $savedDresseur = $entityManager->getRepository(Dresseur::class)->find($dresseur->getId());
            $savedPkmn = $entityManager->getRepository(Pkmn::class)->find($pkmn->getId());

            self::assertInstanceOf(Dresseur::class, $savedDresseur);
            self::assertInstanceOf(Pkmn::class, $savedPkmn);
            self::assertSame($user->getId(), $savedDresseur->getUser()?->getId());
            self::assertSame('Sacha', $savedDresseur->getName());
            self::assertSame(25, $savedDresseur->getPkmn1Id());
            self::assertNull($savedDresseur->getPkmn2Id());
            self::assertSame($savedDresseur->getId(), $savedPkmn->getDresseur()?->getId());
            self::assertSame('Pikachu', $savedPkmn->getName());
            self::assertSame(31, $savedPkmn->getIvStr());
            self::assertSame(252, $savedPkmn->getEvDex());
            self::assertSame('Balle Lumière', $savedPkmn->getHeldItem());
        } finally {
            $connection->rollBack();
        }
    }
}
