<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeProRepository")
 */
class CommandePro
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promo", inversedBy="commandesPros")
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DetailCdePro", mappedBy="commandePro", orphanRemoval=true)
     */
    private $detailCdePro;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pro", inversedBy="commandePro")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pro;

    public function __construct()
    {
        $this->promo = new ArrayCollection();
        $this->detailCdePro = new ArrayCollection();
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
     * @return Collection|DetailCdePro[]
     */
    public function getDetailCdePro(): Collection
    {
        return $this->detailCdePro;
    }

    public function addDetailCdePro(DetailCdePro $detailCdePro): self
    {
        if (!$this->detailCdePro->contains($detailCdePro)) {
            $this->detailCdePro[] = $detailCdePro;
            $detailCdePro->setCommandePro($this);
        }

        return $this;
    }

    public function removeDetailCdePro(DetailCdePro $detailCdePro): self
    {
        if ($this->detailCdePro->contains($detailCdePro)) {
            $this->detailCdePro->removeElement($detailCdePro);
            // set the owning side to null (unless already changed)
            if ($detailCdePro->getCommandePro() === $this) {
                $detailCdePro->setCommandePro(null);
            }
        }

        return $this;
    }

    public function getPro(): ?Pro
    {
        return $this->pro;
    }

    public function setPro(?Pro $pro): self
    {
        $this->pro = $pro;

        return $this;
    }
}
