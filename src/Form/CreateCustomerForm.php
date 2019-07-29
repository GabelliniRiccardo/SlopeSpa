<?php

namespace App\Form;

use App\Command\Staff\Customer\CreateCustomer;
use App\Form\DTO\CustomerDTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateCustomerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer',
                CustomerDTOForm::class,
                [
                    'property_path' => 'customerDTO',
                    'label' => false,
                ]
            )
            ->add('create',
                SubmitType::class,
                [
                    'label_format' => 'CustomerForm.CreateButton',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateCustomer::class,
        ]);
    }
}
