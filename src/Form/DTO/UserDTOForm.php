<?php


namespace App\Form\DTO;


use App\Model\DTO\UserDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDTOForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class,
            [
                'label_format' => 'UserForm.Name.Value',
                'attr' => [
                    'placeholder' => 'UserForm.Name.Placeholder'
                ]
            ])
            ->add('lastName', TextType::class,
                [
                    'label_format' => 'UserForm.LastName.Value',
                    'attr' => [
                        'placeholder' => 'UserForm.LastName.Placeholder'
                    ]
                ])
            ->add('email', EmailType::class,
                [
                    'label_format' => 'UserForm.Email.Value',
                    'attr' => [
                        'placeholder' => 'UserForm.Email.Placeholder'
                    ]
                ])
            ->add('password', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'DTO.UserDTO.Password.PasswordFieldMustMatch',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options' => ['label_format' => 'UserForm.Password'],
                    'second_options' => ['label_format' => 'UserForm.RepeatPassword'],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserDTO::class,
        ]);
    }
}
