<?php

namespace App\Form;

use App\Entity\Boat;
use App\Entity\Lunch;
use App\Entity\Schedule;
use App\Entity\TimeSlot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('phoneNumber', TextType::class)
            ->add('timeSlot', EntityType::class,
                [
                    'class' => TimeSlot::class,
                    'choice_label' => function(TimeSlot $timeSlot)
                    {
                            return $timeSlot->getPeriod()." ( free ".($timeSlot->getCapacity()- count($timeSlot->getSchedule()))." of ".$timeSlot->getCapacity().")";
                    },
                    'expanded' => true,
                    'multiple' => false,
                ]

                )
            ->add('boat', EntityType::class,
                [
                    'class' => Boat::class,
                    'choice_label' => 'type',
                ]
                )
            ->add('lunch', EntityType::class,
                [
                    'class' => Lunch::class,
                    'choice_label' => 'type',
                ]
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
