<?php

namespace App\Form;

use App\Entity\Pro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        dump($options);
        
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('societe')
            ->add('siret')
            ->add('adresse')
            ->add('telephone')
            ->add('email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pro::class,
        ]);
    }
}
