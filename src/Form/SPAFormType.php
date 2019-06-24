<?php

namespace App\Form;

use App\Entity\SPA;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SPAFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label' => 'Set SPA name',
                    'attr' => [
                        'placeholder' => 'SPA\'s name'
                    ]
                ])
            ->add('email', TextType::class,
                [
                    'label' => 'Set SPA\'s email',
                    'attr' => [
                        'placeholder' => 'SPA\'s email'
                    ]
                ])
            ->add('address', TextType::class,
                [
                    'label' => 'Set SPA\'s address (*not required)',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'SPA\'s address'
                    ],
                ])->add('phoneNumber', TextType::class,
                [
                    'label' => 'Set phone number (*not required)',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'SPA\'s phone number'
                    ],
                ])
            ->add('create', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SPA::class,
        ]);
    }
}
