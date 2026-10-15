<?php

namespace App\Form;

use App\Entity\Dresseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @extends AbstractType<Dresseur>
 */
final class DresseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank(message: 'Saisis le prénom du dresseur.'),
                    new Length(max: 100),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank(message: 'Saisis le nom du dresseur.'),
                    new Length(max: 100),
                ],
            ])
            ->add('genre', TextType::class, [
                'label' => 'Genre (facultatif)',
                'required' => false,
                'constraints' => [
                    new Length(max: 20),
                ],
            ])
            ->add('str', IntegerType::class, [
                'label' => 'Force',
                'attr' => ['min' => 1, 'max' => 5],
            ])
            ->add('dex', IntegerType::class, [
                'label' => 'Dextérité',
                'attr' => ['min' => 1, 'max' => 5],
            ])
            ->add('con', IntegerType::class, [
                'label' => 'Constitution',
                'attr' => ['min' => 1, 'max' => 5],
            ])
            ->add('end', IntegerType::class, [
                'label' => 'Endurance',
                'attr' => ['min' => 1, 'max' => 5],
            ])
            ->add('vol', IntegerType::class, [
                'label' => 'Volonté',
                'attr' => ['min' => 1, 'max' => 5],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dresseur::class,
        ]);
    }
}
