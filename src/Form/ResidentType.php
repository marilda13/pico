<?php

namespace App\Form;

use App\Entity\Resident;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

final class ResidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, [
                'label' => 'Id'
            ])
            ->add('username', TextType::class, [
                'label' => 'Username'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Firstname'
            ])
            ->add('surname', TextType::class, [
                'label' => 'Surname'
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'choices' => [
                    'female' => 'female',
                    'male' => 'male',
                ],
                'placeholder' => 'Choose an option',
            ])
            ->add('birthday', TextType::class, [
                'label' => 'Birthday',
                'help' => 'YYYY-MM-DD',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{4}-\d{2}-\d{2}$/',
                        'message' => 'The date format should be yyyy-mm-dd.',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Address'
            ])
            ->add('quote', TextareaType::class, [
                'label' => 'Quote',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resident::class,
        ]);
    }
}