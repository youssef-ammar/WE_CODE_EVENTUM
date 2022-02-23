<?php

namespace App\Form;

use App\Entity\Topic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description',TextareaType::class)
            ->add('Categorie', ChoiceType::class, [
                'choices' => [
                    ''=>'0',
                    'Events' => 'Events',
                    'Travel' => 'Travel',
                    'Camping' => 'Camping',
                    'Shopping' => 'Shopping',
                ],
            ])

            ->add('public', ChoiceType::class, [
                'choices' => [
                    ''=>'0',
                    'Public' => 'Public',
                    'Private' => 'Private',

                ],
            ])

            /* ->add('sharef', CheckboxType::class, ['label'=>'Facebook' ,'mapped' => false])
             ->add('sharet', CheckboxType::class, ['label'=>'Twitter' ,'mapped' => false])
             ->add('sharer', CheckboxType::class, ['label'=>'Reddit' ,'mapped' => false])*/






            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,

            ])
            ->add('Ajouter',SubmitType::class)
            ->add('Modifier',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
