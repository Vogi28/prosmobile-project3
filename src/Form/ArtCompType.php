<?php

namespace App\Form;

use App\Entity\ArtComp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtCompType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            ->add('artId')
            ->add('artCompId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArtComp::class,
        ]);
    }
}
