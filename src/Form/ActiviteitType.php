<?php

namespace App\Form;

use App\Entity\Activiteiten;
use App\Entity\SoortActiviteiten;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datum', DateType::class, ['attr' => ['class' => 'js-datepicker', 'placeholder' => 'dd-mm-yyyy'],
                'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'
            ])
            ->add('tijd', TimeType::class, ['attr' => ['class' => 'js-timepicker', 'placeholder' => 'hh:mm'],
                'widget' => 'single_text', 'html5' => false,])
            ->add('soort', EntityType::class,
                ['class' => SoortActiviteiten::class,
                    'choice_label' => 'naam',])
            ->add('maxDeelnemers', null, ['label' => 'maximaal aantal deelnemers']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activiteiten::class,
        ]);
    }
}
