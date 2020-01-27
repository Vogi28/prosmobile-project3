<?php

namespace App\Form;

use App\Entity\Marque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez un nom de marque'
                ]
            ])
            ->add('image', UrlType::class, [
                'label' => 'Image',
                'default_protocol' => 'https',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrez un lien d\'image'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Marque::class,
        ]);
    }
}
