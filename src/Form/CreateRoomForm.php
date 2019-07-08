<?php

namespace App\Form;

use App\Command\Staff\Room\CreateRoom;
use App\Form\DTO\RoomDTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateRoomForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_',
                RoomDTOForm::class,
                [
                    'property_path' => 'roomDTO',
                ]
            )
            ->add('create',
                SubmitType::class,
                [
                    'label_format' => 'RoomForm.CreateButton',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateRoom::class,
        ]);
    }
}
