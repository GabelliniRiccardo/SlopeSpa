<?php


namespace App\Form\DTO;


use App\Model\DTO\ReservationDTO;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationDTOForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', EntityType::class,
                [
                    'class' => 'App\Entity\Customer',
                    'label_format' => 'ReservationForm.Customer.Value',
                    'placeholder' => 'ReservationForm.Customer.Placeholder',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c');
                    }
                ])
            ->add('start_time', DateTimeType::class,
                [
                    'placeholder' => [
                        'year' => 'ReservationForm.StartTime.Year',
                        'month' => 'ReservationForm.StartTime.Month',
                        'day' => 'ReservationForm.StartTime.Day',
                        'hour' => 'ReservationForm.StartTime.Hour',
                        'minute' => 'ReservationForm.StartTime.Minute',
                    ],
                    'years' => range(date("Y"), date("Y") + 5),
                    'input' => 'datetime_immutable',
                    'label_format' => 'ReservationForm.StartTime.Value',
                ])
            ->add('treatment', EntityType::class,
                [
                    'class' => 'App\Entity\Treatment',
                    'label_format' => 'ReservationForm.Treatment.Value',
                    'placeholder' => 'ReservationForm.Treatment.Placeholder',
                    'choices' => $options['treatments']
                ])
            ->add('operator', EntityType::class,
                [
                    'class' => 'App\Entity\Operator',
                    'label_format' => 'ReservationForm.Operator.Value',
                    'placeholder' => 'ReservationForm.Operator.Placeholder',
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => $options['operators']
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationDTO::class,
        ]);
        $resolver->setRequired('treatments');
        $resolver->setRequired('operators');
    }
}

{

}
