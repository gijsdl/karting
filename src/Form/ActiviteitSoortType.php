<?php

namespace App\Form;

use App\Entity\SoortActiviteiten;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteitSoortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('naam')
            ->add('beschrijving')
            ->add('minLeeftijd')
            ->add('tijdsduur')
            ->add('prijs')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SoortActiviteiten::class,
        ]);
    }
}
