<?php

namespace App\Form;

use App\Command\Staff\Reservation\CreateReservation;
use App\Form\DTO\ReservationDTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateReservationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reservation',
                ReservationDTOForm::class,
                [
                    'property_path' => 'reservationDTO',
                    'treatments' => $options['treatments'],
                    'operators' => $options['operators'],
                    'label' => false
                ]
            )
            ->add('create',
                SubmitType::class,
                [
                    'label_format' => 'ReservationForm.CreateButton',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateReservation::class,
        ]);
        $resolver->setRequired('treatments');
        $resolver->setRequired('operators');

    }
}
