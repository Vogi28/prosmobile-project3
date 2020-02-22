<?php

namespace App\Form;

use App\Entity\TypeArt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeArtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;

        $builder
            ->add('nom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeArt::class,
        ]);
    }
}
