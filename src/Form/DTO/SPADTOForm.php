<?php

namespace App\Form\DTO;

use App\Model\DTO\SPADTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SPADTOForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label_format' => 'SpaForm.Name.Value',
                    'attr' => [
                        'placeholder' => 'SpaForm.Name.Placeholder'
                    ]
                ])
            ->add('email', EmailType::class,
                [
                    'label_format' => 'SpaForm.Email.Value',
                    'attr' => [
                        'placeholder' => 'SpaForm.Email.Placeholder'
                    ]
                ])
            ->add('address', TextType::class,
                [
                    'label_format' => 'SpaForm.Address.Value',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'SpaForm.Address.Placeholder'
                    ],
                ])
            ->add('phoneNumber', TextType::class,
                [
                    'label_format' => 'SpaForm.PhoneNumber.Value',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'SpaForm.PhoneNumber.Placeholder'
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SPADTO::class,
        ]);
    }
}
