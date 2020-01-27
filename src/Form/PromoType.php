<?php

namespace App\Form;

use App\Entity\Promo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;

        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez un nom de promotion'
                ]
            ])
            ->add('debut', DateType::class, [
                'label' => 'Date de début de la promotion',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('fin', DateType::class, [
                'label' => 'Date de fin de la promotion',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('pourcentage', IntegerType::class, [
                'label' => 'Remise',
                'attr' => [
                    'min'  => 0,
                    'max'  => 100
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promo::class,
        ]);
    }
}
