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
    public function getCommandesPar(): Collection
    {
        return $this->commandePar;
    }

    public function addCommandesPar(CommandePar $commandesPar): self
    {
        if (!$this->commandePar->contains($commandesPar)) {
            $this->commandePar[] = $commandesPar;
            $commandesPar->addPromo($this);
        }

        return $this;
    }

    public function removeCommandesPar(CommandePar $commandesPar): self
    {
        if ($this->commandePar->contains($commandesPar)) {
            $this->commandePar->removeElement($commandesPar);
            $commandesPar->removePromo($this);
        }

        return $this;
    }

    /**
     * @return Collection|CommandePro[]
     */
    public function getCommandesPros(): Collection
    {
        return $this->commandePro;
    }

    public function addCommandesPro(CommandePro $commandesPro): self
    {
        if (!$this->commandePro->contains($commandesPro)) {
            $this->commandePro[] = $commandesPro;
            $commandesPro->addPromo($this);
        }

        return $this;
    }

    public function removeCommandesPro(CommandePro $commandesPro): self
    {
        if ($this->commandePro->contains($commandesPro)) {
            $this->commandePro->removeElement($commandesPro);
            $commandesPro->removePromo($this);
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
}
