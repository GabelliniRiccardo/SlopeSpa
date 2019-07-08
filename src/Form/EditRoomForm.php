<?php

namespace App\Form;

use App\Command\Staff\Room\EditRoom;
use App\Entity\Room;
use App\Form\DTO\RoomDTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditRoomForm extends AbstractType
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
            ->add('edit',
                SubmitType::class,
                [
                    'label_format' => 'RoomForm.EditButton',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditRoom::class,
        ]);
    }
}
