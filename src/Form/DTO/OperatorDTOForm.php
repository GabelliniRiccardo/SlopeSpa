<?php


namespace App\Form\DTO;


use App\Model\DTO\OperatorDTO;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperatorDTOForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $treatments = $options['treatments'];
        $builder
            ->add('firstName', TextType::class,
                [
                    'label_format' => 'OperatorForm.Name.Value',
                    'attr' => [
                        'placeholder' => 'OperatorForm.Name.Placeholder'
                    ]
                ])
            ->add('lastName', TextType::class,
                [
                    'label_format' => 'OperatorForm.LastName.Value',
                    'attr' => [
                        'placeholder' => 'OperatorForm.LastName.Placeholder'
                    ]
                ])
            ->add('phoneNumber', TextType::class,
                [
                    'label_format' => 'OperatorForm.PhoneNumber.Value',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'OperatorForm.PhoneNumber.Placeholder'
                    ],
                ])
            ->add('treatments', ChoiceType::class,
                [
                    'choices' =>  $treatments,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OperatorDTO::class,
        ]);

        $resolver->setRequired('treatments'); // Requires that currentOrg be set by the caller.
        $resolver->setAllowedTypes('treatments', PersistentCollection::class); // Validates the type(s) of option(s) passed.
    }
}
