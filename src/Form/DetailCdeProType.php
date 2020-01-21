<?php

namespace App\Form;

use App\Entity\DetailCdePro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailCdeProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            // ->add('nomArt')
            ->add('quantite')
            // ->add('prixHt')
            // ->add('remise')
            // ->add('total')
            // ->add('commandePro')
            // ->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailCdePro::class,
        ]);
    }
}
