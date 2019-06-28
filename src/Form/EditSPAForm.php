<?php

namespace App\Form;

use App\Command\Admin\EditSPA;
use App\Form\DTO\SPADTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditSPAForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('SPA',
                SPADTOForm::class,
                [
                    'property_path' => 'spaDTO',
                ]
            )
            ->add('edit',
                SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditSPA::class,
        ]);
    }
}
