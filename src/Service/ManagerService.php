<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class ManagerService
{
    protected $emi;

    public function __construct(EntityManagerInterface $emi)
    {
        $this->emi = $emi;
    }

    public function persFLush(object $objet)
    {
        $this->emi->persist($objet);
        $this->emi->flush();
    }

    public function remFlush(object $objet)
    {
        $this->emi->remove($objet);
        $this->emi->flush();
    }
}
