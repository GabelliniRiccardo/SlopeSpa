<?php


namespace App\Form\DTO;


use App\Model\DTO\TreatmentDTO;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TreatmentDTOForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label_format' => 'TreatmentForm.Name.Value',
                    'attr' => [
                        'placeholder' => 'TreatmentForm.Name.Placeholder'
                    ]
                ])
            ->add('money', MoneyType::class,
                [
                    'label_format' => 'TreatmentForm.Price.Value',
                    'attr' => [
                        'placeholder' => 'TreatmentForm.Price.Placeholder',
                        'class' => 'col-6 col-md-3'
                    ]
                ])
            ->add('duration', TimeType::class,
                [
                    'input' => 'timestamp', // Type of input to render
                    'label_format' => 'TreatmentForm.Duration.Value',
                    'placeholder' => [
                        'hour' => 'TreatmentForm.Duration.Hour', 'minute' => 'TreatmentForm.Duration.Minute'
                    ],
                    'minutes' => range(1,59)
                ])
            ->add('vat', PercentType::class,
                [
                    'label_format' => 'TreatmentForm.VAT.Value',
                    'attr' => [
                        'placeholder' => 'TreatmentForm.VAT.Placeholder',
                        'class' => 'col-6 col-md-3'
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TreatmentDTO::class,
        ]);
    }
}
