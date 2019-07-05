<?php


namespace App\Form\Types;


use App\Objects\Money;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoneyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', MoneyType::class,
                [
                    'label_format' => 'TreatmentForm.Price.Value',
                    'attr' => [
                        'placeholder' => 'TreatmentForm.Price.Placeholder',
                        'class' => 'col-6 col-md-3'
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Money::class,
        ]);
    }
}
