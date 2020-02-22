<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DetailCdePartRepository")
 */
class DetailCdePart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CommandePar", inversedBy="detailCdePart")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandePar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="detailCdeParts")
     */
    private $article;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomArt;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer")
     */
    private $prixHt;

    /**
     * @ORM\Column(type="integer")
     */
    private $prixTtc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $promo;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandePar(): ?CommandePar
    {
        return $this->commandePar;
    }

    public function setCommandePar(?CommandePar $commandePar): self
    {
        $this->commandePar = $commandePar;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
        }

        return $this;
    }

    public function getNomArt(): ?string
    {
        return $this->nomArt;
    }

    public function setNomArt(string $nomArt): self
    {
        $this->nomArt = $nomArt;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixHt(): ?int
    {
        return $this->prixHt;
    }

    public function setPrixHt(int $prixHt): self
    {
        $this->prixHt = $prixHt;

        return $this;
    }

    public function getPrixTtc(): ?int
    {
        return $this->prixTtc;
    }

    public function setPrixTtc(int $prixTtc): self
    {
        $this->prixTtc = $prixTtc;

        return $this;
    }

    public function getPromo(): ?int
    {
        return $this->promo;
    }

    public function setPromo(?int $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }
}
