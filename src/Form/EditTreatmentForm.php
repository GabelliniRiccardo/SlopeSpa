<?php

namespace App\Form;

use App\Command\Staff\Treatment\EditTreatment;
use App\Form\DTO\TreatmentDTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTreatmentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('treatment',
                TreatmentDTOForm::class,
                [
                    'property_path' => 'treatmentDTO',
                    'label' => false,
                ]
            )
            ->add('edit',
                SubmitType::class,
                [
                    'label_format' => 'TreatmentForm.EditButton',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditTreatment::class,
        ]);
    }
}
