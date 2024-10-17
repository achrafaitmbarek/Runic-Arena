<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Chaos' => 'Chaos',
                    'Halo' => 'Halo',
                ],
            ])
            ->add('class', ChoiceType::class, [
                'choices' => [
                    'Mage' => 'Mage',
                    'Soigneur' => 'Soigneur',
                    'Guerrier' => 'Guerrier',
                    'Archer' => 'Archer',
                    'Assassin' => 'Assassin',
                ],
            ])
            ->add('attackPower', IntegerType::class)
            // We'll add the image field later when we set up VichUploaderBundle
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
