<?php

namespace App\Form;

use App\Entity\Spec;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;

        $builder
            ->add('nom')
            ->add('idGroupe')
            ->add('valeur')
            ->add('unite')
            ->add('articles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spec::class,
        ]);
    }
}
