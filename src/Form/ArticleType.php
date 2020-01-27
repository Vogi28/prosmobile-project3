<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\TypeArt;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            ->add('nom')
            ->add('photo', UrlType::class, [
                'label' => 'Photo',
                'default_protocol' => 'https',
                'required' => false,
                'attr' => [
                    'placeholder' => '',
                    'pattern' => '^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?
                    [a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$'
                ]
            ])
            ->add('reference')
            ->add('description')
            ->add('prixHt')
            ->add('prixTtc')
            ->add('stock')
            ->add('typeArt', EntityType::class, [
                'class' => TypeArt::class,
                'choice_label' => 'nom'
            ])
            ->add('spec', CollectionType::class, [
                'entry_type' => SpecType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
