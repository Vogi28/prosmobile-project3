<?php

namespace App\Form;

use App\Entity\Pro;
use App\Entity\CommandePro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
        ->add('id')
        ->add('pro', EntityType::class, [
            'class' => Pro::class,
            'choice_label' => 'id'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandePro::class,
        ]);
    }
}
