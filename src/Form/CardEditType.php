<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CardEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Chaos' => 'Chaos',
                    'Halo' => 'Halo',
                ],
                'attr' => [
                    'class' => '',
                    'style' => 'background-color: white !important;padding: 0.6rem 0rem; color:#0A0B1E ;text-align: center;font-size: 1.2rem ;font-weight: bold'
                ]
            ])
            ->add('class', ChoiceType::class, [
                'choices' => [
                    'Mage' => 'Mage',
                    'Soigneur' => 'Soigneur',
                    'Guerrier' => 'Guerrier',
                    'Archer' => 'Archer',
                    'Assassin' => 'Assassin',
                ],
                'attr' => [
                    'class' => '',
                    'style' => 'background-color: white !important;padding: 0.6rem 0rem; color:#0A0B1E ;text-align: center;font-size: 1.2rem ;font-weight: bold'
                ]
            ])
            ->add('attackPower', IntegerType::class, [
                'attr' => [
                    'class' => '',
                    'style' => 'background-color: white !important;padding: 0.6rem 0rem; color:#0A0B1E ;text-align: center;font-size: 1.2rem ;font-weight: bold'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
                'label' => 'Avatar',
                'attr' => [
                    'class' => 'hidden',
                    'style' => 'display: none;'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
