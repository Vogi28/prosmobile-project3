<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtCompRepository")
 */
class ArtComp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $artId;

    /**
     * @ORM\Column(type="integer")
     */
    private $artCompId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtId(): ?int
    {
        return $this->artId;
    }

    public function setArtId(int $artId): self
    {
        $this->artId = $artId;

        return $this;
    }

    public function getArtCompId(): ?int
    {
        return $this->artCompId;
    }

    public function setArtCompId(int $artCompId): self
    {
        $this->artCompId = $artCompId;

        return $this;
    }
}
