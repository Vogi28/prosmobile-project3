<?php

namespace App\Form;

use App\Entity\Particulier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticulierFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez une adresse'
                ]
            ])
            ->add('codePostal', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez un code postal'
                ]
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez une ville'
                ]
            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez un numéro de téléphone'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Particulier::class,
        ]);
    }
}
