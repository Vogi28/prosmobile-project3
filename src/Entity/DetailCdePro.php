<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DetailCdeProRepository")
 */
class DetailCdePro
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CommandePro", inversedBy="detailCdePro")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandePro;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandePro(): ?CommandePro
    {
        return $this->commandePro;
    }

    public function setCommandePro(?CommandePro $commandePro): self
    {
        $this->commandePro = $commandePro;

        return $this;
    }
}
