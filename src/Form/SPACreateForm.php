<?php

namespace App\Form;

use App\Entity\SPA;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SPACreateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'SPA\'s name'
                    ]
                ])
            ->add('email', EmailType::class,
                [
                    'attr' => [
                        'placeholder' => 'example@example.com'
                    ]
                ])
            ->add('address', TextType::class,
                [
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'SPA\'s address'
                    ],
                ])->add('phoneNumber', TextType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'SPA\'s phone number'
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SPA::class,
        ]);
    }
}
