<?php


namespace App\Form\DTO;


use App\Model\DTO\RoomDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomDTOForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label_format' => 'RoomForm.Name.Value',
                    'attr' => [
                        'placeholder' => 'RoomForm.Name.Placeholder'
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RoomDTO::class,
        ]);
    }
}

{

}
