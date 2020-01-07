<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            ->add('nom')
            ->add('photo')
            ->add('reference')
            ->add('description')
            ->add('prixHt')
            ->add('prixTtc')
            ->add('stock')
            ->add('typeArt')
            ->add('spec')
            ->add('detailCdeParts')
            ->add('detailCdePros')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
