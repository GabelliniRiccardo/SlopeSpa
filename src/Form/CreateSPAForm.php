<?php

namespace App\Form;


use App\Command\Admin\CreateSPA;
use App\Form\DTO\SPADTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateSPAForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('spa',
                SPADTOForm::class,
                [
                    'property_path' => 'spaDTO',
                    'label' => false,
                ]
            )
            ->add('create',
                SubmitType::class,
                [
                    'label_format' => 'SpaForm.CreateButton',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateSPA::class,
        ]);
    }
}
