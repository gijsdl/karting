<?php

namespace App\Form;

use App\Entity\AppUsers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class
                , array(
                    'label' => 'Gebruikersnaam'))
            ->add('currentPassword', PasswordType::class, [
                'mapped' => false,
                'help' => 'vul huidig wachtwoord in',
                'label' => 'huidig wachtwoord'
            ])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Wachtwoord'],
                'second_options' => ['label' => 'Herhaal wachtwoord'],
            ))
            ->add('voorletters')
            ->add('tussenvoegsel')
            ->add('achternaam')
            ->add('adres')
            ->add('postcode')
            ->add('woonplaats')
            ->add('email')
            ->add('telefoon');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AppUsers::class,
        ]);
    }
}
