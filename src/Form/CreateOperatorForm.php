<?php

namespace App\Form;

use App\Command\Staff\Operator\CreateOperator;
use App\Form\DTO\OperatorDTOForm;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateOperatorForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $treatments = $options['treatments'];
        $builder
            ->add('_',
                OperatorDTOForm::class,
                [
                    'property_path' => 'operatorDTO',
                    'treatments' => $treatments
                ]
            )
            ->add('create',
                SubmitType::class,
                [
                    'label_format' => 'OperatorForm.CreateButton',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateOperator::class,
        ]);
        $resolver->setRequired('treatments'); // Requires that currentOrg be set by the caller.
        $resolver->setAllowedTypes('treatments', PersistentCollection::class); // Validates the type(s) of option(s) passed.
    }
}
