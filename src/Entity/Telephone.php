<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TelephoneRepository")
 */
class Telephone
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
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modele", inversedBy="telephones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modele;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Version", inversedBy="telephones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $version;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Composant", mappedBy="telephone")
     */
    private $composant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="telephone")
     */
    private $service;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Accessoire", inversedBy="telephones")
     */
    private $accessoire;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    public function __construct()
    {
        $this->composant = new ArrayCollection();
        $this->service = new ArrayCollection();
        $this->accessoire = new ArrayCollection();
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

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getVersion(): ?Version
    {
        return $this->version;
    }

    public function setVersion(?Version $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return Collection|Composant[]
     */
    public function getComposant(): Collection
    {
        return $this->composant;
    }

    public function addComposant(Composant $composant): self
    {
        if (!$this->composant->contains($composant)) {
            $this->composant[] = $composant;
            $composant->setTelephone($this);
        }

        return $this;
    }

    public function removeComposant(Composant $composant): self
    {
        if ($this->composant->contains($composant)) {
            $this->composant->removeElement($composant);
            // set the owning side to null (unless already changed)
            if ($composant->getTelephone() === $this) {
                $composant->setTelephone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Service $service): self
    {
        if (!$this->service->contains($service)) {
            $this->service[] = $service;
            $service->setTelephone($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->service->contains($service)) {
            $this->service->removeElement($service);
            // set the owning side to null (unless already changed)
            if ($service->getTelephone() === $this) {
                $service->setTelephone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Accessoire[]
     */
    public function getAccessoire(): Collection
    {
        return $this->accessoire;
    }

    public function addAccessoire(Accessoire $accessoire): self
    {
        if (!$this->accessoire->contains($accessoire)) {
            $this->accessoire[] = $accessoire;
        }

        return $this;
    }

    public function removeAccessoire(Accessoire $accessoire): self
    {
        if ($this->accessoire->contains($accessoire)) {
            $this->accessoire->removeElement($accessoire);
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
}
