<?php


namespace App\Form\DTO;


use App\Model\DTO\CustomerDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerDTOForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,
                [
                    'label_format' => 'CustomerForm.FirstName.Value',
                    'attr' => [
                        'placeholder' => 'CustomerForm.FirstName.Placeholder'
                    ]
                ])
            ->add('lastName', TextType::class,
                [
                    'label_format' => 'CustomerForm.LastName.Value',
                    'attr' => [
                        'placeholder' => 'CustomerForm.LastName.Placeholder'
                    ]
                ])
            ->add('birthday', DateType::class,
                [
                    'label_format' => 'CustomerForm.Birthday.Value',
                    'input' => 'datetime_immutable',
                    'placeholder' => [
                        'year' => 'CustomerForm.Birthday.Year', 'month' => 'CustomerForm.Birthday.Month', 'day' => 'CustomerForm.Birthday.Day',
                    ],
                    'years' =>  array_reverse(range(1910,date("Y"))),
                     'required' => false
                ])
            ->add('address', TextType::class,
                [
                    'label_format' => 'CustomerForm.Address.Value',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'CustomerForm.Address.Placeholder'
                    ],
                ])
            ->add('phoneNumber', TextType::class,
                [
                    'label_format' => 'CustomerForm.PhoneNumber.Value',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'CustomerForm.PhoneNumber.Placeholder'
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CustomerDTO::class,
        ]);
    }
}
