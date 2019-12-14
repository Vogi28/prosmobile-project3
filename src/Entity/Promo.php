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
    private $commandesPar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CommandePro", mappedBy="promo")
     */
    private $commandesPro;

    public function __construct()
    {
        $this->commandesPar = new ArrayCollection();
        $this->commandesPro = new ArrayCollection();
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
        return $this->commandesPar;
    }

    public function addCommandesPar(CommandePar $commandesPar): self
    {
        if (!$this->commandesPar->contains($commandesPar)) {
            $this->commandesPar[] = $commandesPar;
            $commandesPar->addPromo($this);
        }

        return $this;
    }

    public function removeCommandesPar(CommandePar $commandesPar): self
    {
        if ($this->commandesPar->contains($commandesPar)) {
            $this->commandesPar->removeElement($commandesPar);
            $commandesPar->removePromo($this);
        }

        return $this;
    }

    /**
     * @return Collection|CommandePro[]
     */
    public function getCommandesPros(): Collection
    {
        return $this->commandesPro;
    }

    public function addCommandesPro(CommandePro $commandesPro): self
    {
        if (!$this->commandesPro->contains($commandesPro)) {
            $this->commandesPro[] = $commandesPro;
            $commandesPro->addPromo($this);
        }

        return $this;
    }

    public function removeCommandesPro(CommandePro $commandesPro): self
    {
        if ($this->commandesPro->contains($commandesPro)) {
            $this->commandesPro->removeElement($commandesPro);
            $commandesPro->removePromo($this);
        }

        return $this;
    }
}
