<?php

namespace App\Form;

use App\Entity\DetailCdePart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailCdePartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            // ->add('nomArt')
            ->add('quantite')
            // ->add('prixHt')
            // ->add('prixTtc')
            // ->add('promo')
            // ->add('total')
            // ->add('commandePar')
            // ->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailCdePart::class,
        ]);
    }
}
