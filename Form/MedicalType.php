<?php

namespace App\Form;

use App\Entity\Medical;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('refId')
            ->add('category')
            ->add('dateO', null, [
                'widget' => 'single_text',
            ])
            ->add('whenO')
            ->add('whereO')
            ->add('whoO')
            ->add('person')
            ->add('title')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medical::class,
        ]);
    }
}