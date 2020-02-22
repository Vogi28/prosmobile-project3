<?php

namespace App\Form;

use App\Entity\CommandePar;
use App\Entity\Particulier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeParType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            // ->add('promo')
            // ->add('id')
            ->add('particulier', EntityType::class, [
                'class' => Particulier::class,
                'choice_label' => 'id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandePar::class,
        ]);
    }
}
