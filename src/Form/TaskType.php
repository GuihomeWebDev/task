<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'nom de la tache',
                'attr' => [
                    'placeholder' => 'nom de la tache'
                ]
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de la tache',
                'attr' => [
                    'placeholder' => 'Description (optionelle)'
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
