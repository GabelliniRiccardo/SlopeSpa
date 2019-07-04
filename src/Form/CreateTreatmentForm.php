<?php

namespace App\Form;

use App\Command\Staff\Treatment\CreateTreatment;
use App\Form\DTO\TreatmentDTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateTreatmentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_',
                TreatmentDTOForm::class,
                [
                    'property_path' => 'treatmentDTO',
                ]
            )
            ->add('create',
                SubmitType::class,
                [
                    'label_format' => 'TreatmentForm.CreateButton',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateTreatment::class,
        ]);
    }
}
