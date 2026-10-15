<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity]
#[ORM\Table(name: 'dresseur')]
#[Assert\Callback('validateStatPoints')]
class Dresseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'dresseurs')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(length: 100)]
    private string $name = '';

    #[ORM\Column(length: 100)]
    private string $lastname = '';

    #[ORM\Column(name: 'str', options: ['default' => 1])]
    #[Assert\Range(min: 1, max: 5, notInRangeMessage: 'La force doit être comprise entre {{ min }} et {{ max }}.')]
    private int $str = 1;

    #[ORM\Column(name: 'dex', options: ['default' => 1])]
    #[Assert\Range(min: 1, max: 5, notInRangeMessage: 'La dextérité doit être comprise entre {{ min }} et {{ max }}.')]
    private int $dex = 1;

    #[ORM\Column(name: 'con', options: ['default' => 1])]
    #[Assert\Range(min: 1, max: 5, notInRangeMessage: 'La constitution doit être comprise entre {{ min }} et {{ max }}.')]
    private int $con = 1;

    #[ORM\Column(name: 'end', options: ['default' => 1])]
    #[Assert\Range(min: 1, max: 5, notInRangeMessage: 'L’endurance doit être comprise entre {{ min }} et {{ max }}.')]
    private int $end = 1;

    #[ORM\Column(name: 'vol', options: ['default' => 1])]
    #[Assert\Range(min: 1, max: 5, notInRangeMessage: 'La volonté doit être comprise entre {{ min }} et {{ max }}.')]
    private int $vol = 1;

    #[ORM\Column(name: 'str_temp', options: ['default' => 0])]
    private int $strTemp = 0;

    #[ORM\Column(name: 'dex_temp', options: ['default' => 0])]
    private int $dexTemp = 0;

    #[ORM\Column(name: 'con_temp', options: ['default' => 0])]
    private int $conTemp = 0;

    #[ORM\Column(name: 'end_temp', options: ['default' => 0])]
    private int $endTemp = 0;

    #[ORM\Column(name: 'vol_temp', options: ['default' => 0])]
    private int $volTemp = 0;

    #[ORM\Column(name: 'vit_temp', options: ['default' => 0])]
    private int $vitTemp = 0;

    #[ORM\Column(options: ['default' => 0])]
    private int $money = 0;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nature = null;

    #[ORM\Column(options: ['default' => 0])]
    private int $xp = 0;

    #[ORM\Column(name: 'pkmn_1_id', nullable: true)]
    private ?int $pkmn1Id = null;

    #[ORM\Column(name: 'pkmn_2_id', nullable: true)]
    private ?int $pkmn2Id = null;

    #[ORM\Column(name: 'pkmn_3_id', nullable: true)]
    private ?int $pkmn3Id = null;

    #[ORM\Column(name: 'pkmn_4_id', nullable: true)]
    private ?int $pkmn4Id = null;

    #[ORM\Column(name: 'pkmn_5_id', nullable: true)]
    private ?int $pkmn5Id = null;

    #[ORM\Column(name: 'pkmn_6_id', nullable: true)]
    private ?int $pkmn6Id = null;

    /**
     * @var Collection<int, Pkmn>
     */
    #[ORM\OneToMany(targetEntity: Pkmn::class, mappedBy: 'dresseur')]
    private Collection $pokemon;

    public function __construct()
    {
        $this->pokemon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user?->removeDresseur($this);
        $this->user = $user;
        $user->addDresseur($this);

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStr(): int
    {
        return $this->str;
    }

    public function setStr(int $str): static
    {
        $this->str = $str;

        return $this;
    }

    public function getDex(): int
    {
        return $this->dex;
    }

    public function setDex(int $dex): static
    {
        $this->dex = $dex;

        return $this;
    }

    public function getCon(): int
    {
        return $this->con;
    }

    public function setCon(int $con): static
    {
        $this->con = $con;

        return $this;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function setEnd(int $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getVol(): int
    {
        return $this->vol;
    }

    public function setVol(int $vol): static
    {
        $this->vol = $vol;

        return $this;
    }

    public function getStrTemp(): int
    {
        return $this->strTemp;
    }

    public function setStrTemp(int $strTemp): static
    {
        $this->strTemp = $strTemp;

        return $this;
    }

    public function getDexTemp(): int
    {
        return $this->dexTemp;
    }

    public function setDexTemp(int $dexTemp): static
    {
        $this->dexTemp = $dexTemp;

        return $this;
    }

    public function getConTemp(): int
    {
        return $this->conTemp;
    }

    public function setConTemp(int $conTemp): static
    {
        $this->conTemp = $conTemp;

        return $this;
    }

    public function getEndTemp(): int
    {
        return $this->endTemp;
    }

    public function setEndTemp(int $endTemp): static
    {
        $this->endTemp = $endTemp;

        return $this;
    }

    public function getVolTemp(): int
    {
        return $this->volTemp;
    }

    public function setVolTemp(int $volTemp): static
    {
        $this->volTemp = $volTemp;

        return $this;
    }

    public function getVitTemp(): int
    {
        return $this->vitTemp;
    }

    public function setVitTemp(int $vitTemp): static
    {
        $this->vitTemp = $vitTemp;

        return $this;
    }

    public function getMoney(): int
    {
        return $this->money;
    }

    public function setMoney(int $money): static
    {
        $this->money = $money;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?string $nature): static
    {
        $this->nature = $nature;

        return $this;
    }

    public function getXp(): int
    {
        return $this->xp;
    }

    public function setXp(int $xp): static
    {
        $this->xp = $xp;

        return $this;
    }

    public function getPkmn1Id(): ?int
    {
        return $this->pkmn1Id;
    }

    public function setPkmn1Id(?int $pkmn1Id): static
    {
        $this->pkmn1Id = $pkmn1Id;

        return $this;
    }

    public function getPkmn2Id(): ?int
    {
        return $this->pkmn2Id;
    }

    public function setPkmn2Id(?int $pkmn2Id): static
    {
        $this->pkmn2Id = $pkmn2Id;

        return $this;
    }

    public function getPkmn3Id(): ?int
    {
        return $this->pkmn3Id;
    }

    public function setPkmn3Id(?int $pkmn3Id): static
    {
        $this->pkmn3Id = $pkmn3Id;

        return $this;
    }

    public function getPkmn4Id(): ?int
    {
        return $this->pkmn4Id;
    }

    public function setPkmn4Id(?int $pkmn4Id): static
    {
        $this->pkmn4Id = $pkmn4Id;

        return $this;
    }

    public function getPkmn5Id(): ?int
    {
        return $this->pkmn5Id;
    }

    public function setPkmn5Id(?int $pkmn5Id): static
    {
        $this->pkmn5Id = $pkmn5Id;

        return $this;
    }

    public function getPkmn6Id(): ?int
    {
        return $this->pkmn6Id;
    }

    public function setPkmn6Id(?int $pkmn6Id): static
    {
        $this->pkmn6Id = $pkmn6Id;

        return $this;
    }

    /**
     * @return Collection<int, Pkmn>
     */
    public function getPokemon(): Collection
    {
        return $this->pokemon;
    }

    public function addPokemon(Pkmn $pokemon): static
    {
        if (!$this->pokemon->contains($pokemon)) {
            $this->pokemon->add($pokemon);
        }

        if ($pokemon->getDresseur() !== $this) {
            $pokemon->setDresseur($this);
        }

        return $this;
    }

    public function removePokemon(Pkmn $pokemon): static
    {
        $this->pokemon->removeElement($pokemon);

        return $this;
    }

    /**
     * Return the six configured team slots, resolving only Pokemon owned by this trainer.
     *
     * @return list<Pkmn|null>
     */
    public function getEquipeActuelle(): array
    {
        $team = [];

        foreach ([$this->pkmn1Id, $this->pkmn2Id, $this->pkmn3Id, $this->pkmn4Id, $this->pkmn5Id, $this->pkmn6Id] as $pokemonId) {
            $team[] = $pokemonId === null
                ? null
                : $this->pokemon->findFirst(
                    static fn (int $key, Pkmn $pokemon): bool => $pokemon->getId() === $pokemonId,
                );
        }

        return $team;
    }

    public function validateStatPoints(ExecutionContextInterface $context): void
    {
        if ($this->str + $this->dex + $this->con + $this->end + $this->vol !== 15) {
            $context->buildViolation('Les cinq statistiques doivent totaliser exactement 15 points.')
                ->addViolation();
        }
    }
}
