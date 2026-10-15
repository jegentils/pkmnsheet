<?php

namespace App\Entity;

use App\Repository\PkmnRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PkmnRepository::class)]
#[ORM\Table(name: 'pkmn')]
class Pkmn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Dresseur::class, inversedBy: 'pokemon')]
    #[ORM\JoinColumn(name: 'dresseur_id', nullable: false, onDelete: 'CASCADE')]
    private ?Dresseur $dresseur = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(length: 100)]
    private string $name = '';

    #[ORM\Column]
    private int $number = 0;

    #[ORM\Column(name: 'iv_str', options: ['default' => 0])]
    private int $ivStr = 0;

    #[ORM\Column(name: 'iv_dex', options: ['default' => 0])]
    private int $ivDex = 0;

    #[ORM\Column(name: 'iv_con', options: ['default' => 0])]
    private int $ivCon = 0;

    #[ORM\Column(name: 'iv_end', options: ['default' => 0])]
    private int $ivEnd = 0;

    #[ORM\Column(name: 'iv_vol', options: ['default' => 0])]
    private int $ivVol = 0;

    #[ORM\Column(name: 'ev_str', options: ['default' => 0])]
    private int $evStr = 0;

    #[ORM\Column(name: 'ev_dex', options: ['default' => 0])]
    private int $evDex = 0;

    #[ORM\Column(name: 'ev_con', options: ['default' => 0])]
    private int $evCon = 0;

    #[ORM\Column(name: 'ev_end', options: ['default' => 0])]
    private int $evEnd = 0;

    #[ORM\Column(name: 'ev_vol', options: ['default' => 0])]
    private int $evVol = 0;

    #[ORM\Column(name: 'vit_temp', options: ['default' => 0])]
    private int $vitTemp = 0;

    #[ORM\Column(options: ['default' => 0])]
    private int $affection = 0;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nature = null;

    #[ORM\Column(options: ['default' => 0])]
    private int $xp = 0;

    #[ORM\Column(options: ['default' => false])]
    private bool $soumission = false;

    #[ORM\Column(name: 'held_item', length: 100, nullable: true)]
    private ?string $heldItem = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $talent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDresseur(): ?Dresseur
    {
        return $this->dresseur;
    }

    public function setDresseur(Dresseur $dresseur): static
    {
        $this->dresseur?->removePokemon($this);
        $this->dresseur = $dresseur;
        $dresseur->addPokemon($this);

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

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getIvStr(): int
    {
        return $this->ivStr;
    }

    public function setIvStr(int $ivStr): static
    {
        $this->ivStr = $ivStr;

        return $this;
    }

    public function getIvDex(): int
    {
        return $this->ivDex;
    }

    public function setIvDex(int $ivDex): static
    {
        $this->ivDex = $ivDex;

        return $this;
    }

    public function getIvCon(): int
    {
        return $this->ivCon;
    }

    public function setIvCon(int $ivCon): static
    {
        $this->ivCon = $ivCon;

        return $this;
    }

    public function getIvEnd(): int
    {
        return $this->ivEnd;
    }

    public function setIvEnd(int $ivEnd): static
    {
        $this->ivEnd = $ivEnd;

        return $this;
    }

    public function getIvVol(): int
    {
        return $this->ivVol;
    }

    public function setIvVol(int $ivVol): static
    {
        $this->ivVol = $ivVol;

        return $this;
    }

    public function getEvStr(): int
    {
        return $this->evStr;
    }

    public function setEvStr(int $evStr): static
    {
        $this->evStr = $evStr;

        return $this;
    }

    public function getEvDex(): int
    {
        return $this->evDex;
    }

    public function setEvDex(int $evDex): static
    {
        $this->evDex = $evDex;

        return $this;
    }

    public function getEvCon(): int
    {
        return $this->evCon;
    }

    public function setEvCon(int $evCon): static
    {
        $this->evCon = $evCon;

        return $this;
    }

    public function getEvEnd(): int
    {
        return $this->evEnd;
    }

    public function setEvEnd(int $evEnd): static
    {
        $this->evEnd = $evEnd;

        return $this;
    }

    public function getEvVol(): int
    {
        return $this->evVol;
    }

    public function setEvVol(int $evVol): static
    {
        $this->evVol = $evVol;

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

    public function getAffection(): int
    {
        return $this->affection;
    }

    public function setAffection(int $affection): static
    {
        $this->affection = $affection;

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

    public function isSoumission(): bool
    {
        return $this->soumission;
    }

    public function setSoumission(bool $soumission): static
    {
        $this->soumission = $soumission;

        return $this;
    }

    public function getHeldItem(): ?string
    {
        return $this->heldItem;
    }

    public function setHeldItem(?string $heldItem): static
    {
        $this->heldItem = $heldItem;

        return $this;
    }

    public function getTalent(): ?string
    {
        return $this->talent;
    }

    public function setTalent(?string $talent): static
    {
        $this->talent = $talent;

        return $this;
    }
}
