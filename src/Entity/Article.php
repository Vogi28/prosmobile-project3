<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $prixHt;

    /**
     * @ORM\Column(type="integer")
     */
    private $prixTtc;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeArt", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeArt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Spec", inversedBy="articles", cascade={"persist"})
     */
    private $spec;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DetailCdePart", mappedBy="article")
     */
    private $detailCdeParts;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DetailCdePro", mappedBy="article")
     */
    private $detailCdePros;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="articleSource")
     */
    private $articleTarget;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="articleTarget")
     */
    private $articleSource;

    public function __construct()
    {
        $this->spec = new ArrayCollection();
        $this->detailCdeParts = new ArrayCollection();
        $this->articleTarget = new ArrayCollection();
        $this->articleSource = new ArrayCollection();
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getTypeArt(): ?TypeArt
    {
        return $this->typeArt;
    }

    public function setTypeArt(?TypeArt $typeArt): self
    {
        $this->typeArt = $typeArt;

        return $this;
    }

    /**
     * @return Collection|Spec[]
     */
    public function getSpec(): Collection
    {
        return $this->spec;
    }

    public function addSpec(Spec $spec): self
    {
        if (!$this->spec->contains($spec)) {
            $this->spec[] = $spec;
        }

        return $this;
    }

    public function removeSpec(Spec $spec): self
    {
        if ($this->spec->contains($spec)) {
            $this->spec->removeElement($spec);
        }

        return $this;
    }

    /**
     * @return Collection|DetailCdePart[]
     */
    public function getDetailCdeParts(): Collection
    {
        return $this->detailCdeParts;
    }

    public function addDetailCdePart(DetailCdePart $detailCdePart): self
    {
        if (!$this->detailCdeParts->contains($detailCdePart)) {
            $this->detailCdeParts[] = $detailCdePart;
            $detailCdePart->addArticle($this);
        }

        return $this;
    }

    public function removeDetailCdePart(DetailCdePart $detailCdePart): self
    {
        if ($this->detailCdeParts->contains($detailCdePart)) {
            $this->detailCdeParts->removeElement($detailCdePart);
            $detailCdePart->removeArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection|DetailCdePro[]
     */
    public function getDetailCdePros(): Collection
    {
        return $this->detailCdePros;
    }

    public function addDetailCdePro(DetailCdePro $detailCdePro): self
    {
        if (!$this->detailCdePros->contains($detailCdePro)) {
            $this->detailCdePros[] = $detailCdePro;
            $detailCdePro->addArticle($this);
        }

        return $this;
    }

    public function removeDetailCdePro(DetailCdePro $detailCdePro): self
    {
        if ($this->detailCdePros->contains($detailCdePro)) {
            $this->detailCdePros->removeElement($detailCdePro);
            $detailCdePro->removeArticle($this);
        }

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getArtTarget(): Collection
    {
        return $this->articleTarget;
    }

    public function addArtTarget(Article $article): self
    {
        if (!$this->articleTarget->contains($article)) {
            $this->articleTarget[] = $article;
        }
        return $this;
    }

    public function removeArtTarget(Article $article): self
    {
        if ($this->articleTarget->contains($article)) {
            $this->articleTarget->removeElement($article);
        }
        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getArtSource(): Collection
    {
        return $this->articleSource;
    }

    public function addArtSource(Article $article): self
    {
        if (!$this->articleSource->contains($article)) {
            $this->articleSource[] = $article;
            $article->addArtTarget($this);
        }
        return $this;
    }

    public function removeArtSource(Article $article): self
    {
        if ($this->articleSource->contains($article)) {
            $this->articleSource->removeElement($article);
            $article->removeArtTarget($this);
        }
        return $this;
    }
}
