<?php

namespace App\Entity;

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
}
