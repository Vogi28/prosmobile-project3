<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            ->add('oldPassword', PasswordType::class, [
                'constraints' => array(
                    new UserPassword(
                        ['message' => 'Mot de passe incorrect']
                    ),
                    ),
                'label' => 'Ancien mot de passe',
                'required' => true,
                'mapped' => false
                
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Nouveau mot de passe', 'attr'
                => ['placeholder' => 'Entrez votre nouveau mot de passe']],
                'second_options' => ['label' => 'Confirmer votre mot de passe',
                'attr' => ['placeholder' => 'Confirmer mot de passe']],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Ce champs doit avoir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
