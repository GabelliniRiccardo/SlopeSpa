<?php

namespace App\Form;

use App\Command\Admin\CreateUser;

use App\Form\DTO\UserDTOForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_',
                UserDTOForm::class,
                [
                    'property_path' => 'userDTO',
                ]
            )
            ->add('edit',
                SubmitType::class,
                [
                    'label_format' => 'UserForm.CreateButton',
                ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateUser::class,
        ]);
    }
}
