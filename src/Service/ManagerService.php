<?php

namespace App\Service;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ManagerService
{
    protected $session;
    protected $articleRepository;
    protected $request;
    protected $article;
    protected $articleType;
    protected $emi;

    public function __construct(
        ArticleRepository $articleRepository,
        Request $request,
        Article $article,
        ArticleType $articleType,
        EntityManagerInterface $emi
    ) {
        $this->articleRepository = $articleRepository;
        $this->request = $request;
        $this->article = $article;
        $this->articleType = $articleType;
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
