<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PromoRepository")
 */
class Promo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CommandePar", mappedBy="promo")
     */
    private $commandePar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CommandePro", mappedBy="promo")
     */
    private $commandePro;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="date")
     */
    private $debut;

    /**
     * @ORM\Column(type="date")
     */
    private $fin;

    /**
     * @ORM\Column(type="integer")
     */
    private $pourcentage;


    public function __construct()
    {
        $this->commandePar = new ArrayCollection();
        $this->commandePro = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|CommandePar[]
     */
    public function getCommandePar(): Collection
    {
        return $this->commandePar;
    }

    public function addCommandePar(CommandePar $commandePar): self
    {
        if (!$this->commandePar->contains($commandePar)) {
            $this->commandePar[] = $commandePar;
            $commandePar->addPromo($this);
        }

        return $this;
    }

    public function removeCommandePar(CommandePar $commandePar): self
    {
        if ($this->commandePar->contains($commandePar)) {
            $this->commandePar->removeElement($commandePar);
            $commandePar->removePromo($this);
        }

        return $this;
    }

    /**
     * @return Collection|CommandePro[]
     */
    public function getCommandePro(): Collection
    {
        return $this->commandePro;
    }

    public function addCommandePro(CommandePro $commandePro): self
    {
        if (!$this->commandePro->contains($commandePro)) {
            $this->commandePro[] = $commandePro;
            $commandePro->addPromo($this);
        }

        return $this;
    }

    public function removeCommandePro(CommandePro $commandePro): self
    {
        if ($this->commandePro->contains($commandePro)) {
            $this->commandePro->removeElement($commandePro);
            $commandePro->removePromo($this);
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getPourcentage(): ?int
    {
        return $this->pourcentage;
    }

    public function setPourcentage(int $pourcentage): self
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }
}
