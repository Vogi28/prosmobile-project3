<?php

namespace App\Form;

use App\Entity\Marque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            ->add('nom')
            ->add('image', UrlType::class, [
                'label' => 'Image',
                'default_protocol' => 'https',
                'required' => false,
                'attr' => [
                    'placeholder' => '',
                    'pattern' => '^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?
                    [a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$'
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
