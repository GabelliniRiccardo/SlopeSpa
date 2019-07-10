<?php

namespace App\Form;

use App\Command\Staff\Customer\EditCustomer;
use App\Form\DTO\CustomerDTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCustomerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_',
                CustomerDTOForm::class,
                [
                    'property_path' => 'customerDTO',
                ]
            )
            ->add('edit',
                SubmitType::class,
                [
                    'label_format' => 'CustomerForm.EditButton',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditCustomer::class,
        ]);
    }
}
