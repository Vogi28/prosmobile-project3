<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeParRepository")
 */
class CommandePar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promo", inversedBy="commandePar")
     */
    private $promo;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\DetailCdePart",
     *     mappedBy="commandePar",
     *     orphanRemoval=true, cascade={"persist", "remove"}
     *     )
     */
    private $detailCdePart;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Particulier", inversedBy="commandePar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $particulier;

    public function __construct()
    {
        $this->promo = new ArrayCollection();
        $this->detailCdePart = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromo(): Collection
    {
        return $this->promo;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promo->contains($promo)) {
            $this->promo[] = $promo;
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promo->contains($promo)) {
            $this->promo->removeElement($promo);
        }

        return $this;
    }

    /**
     * @return Collection|DetailCdePart[]
     */
    public function getDetailCdePart(): Collection
    {
        return $this->detailCdePart;
    }

    public function addDetailCdePart(DetailCdePart $detailCdePart): self
    {
        if (!$this->detailCdePart->contains($detailCdePart)) {
            $this->detailCdePart[] = $detailCdePart;
            $detailCdePart->setCommandePar($this);
        }

        return $this;
    }

    public function removeDetailCdePart(DetailCdePart $detailCdePart): self
    {
        if ($this->detailCdePart->contains($detailCdePart)) {
            $this->detailCdePart->removeElement($detailCdePart);
            // set the owning side to null (unless already changed)
            if ($detailCdePart->getCommandePar() === $this) {
                $detailCdePart->setCommandePar(null);
            }
        }

        return $this;
    }

    public function getParticulier(): ?Particulier
    {
        return $this->particulier;
    }

    public function setParticulier(?Particulier $particulier): self
    {
        $this->particulier = $particulier;

        return $this;
    }
}
