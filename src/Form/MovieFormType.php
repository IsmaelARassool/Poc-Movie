<?php

namespace App\Form;

use App\Entity\Productor;
use App\Entity\Category;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MovieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner le titre',
                    ]),
                ],
            ])
            ->add('releaseat', DateType::class, [
                'required' => true,
                'label' => 'Date de sortie',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner la date de sortie',
                    ]),
                ],
            ])
            ->add('synopsis', TextType::class, [
                'required' => true,
                'label' => 'Synopsis',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner le synopsis',
                    ]),
                ],
            ])
            ->add('productor', EntityType::class, [
                'class' => Productor::class,
                'choice_label' => function($productor) {
                    return $productor->getFirstname() . " - " . $productor->getName(); 
                },
                'label' => 'Producteur :',
                'required' => true,
                'multiple' => false,
                'constraints' => new Assert\NotBlank([
                    'message' => 'Veuillez renseigner le producteur',
                ]),
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'label' => false,
                'required' => true,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer un film']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
