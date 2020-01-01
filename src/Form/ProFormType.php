<?php

namespace App\Form;

use App\Entity\Pro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('societe')
            ->add('siret')
            ->add('adresse')
            ->add('telephone')
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pro::class,
        ]);
    }
}
