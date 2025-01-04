<?php

namespace App\Form;

use App\Entity\Aacb;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AacbType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uptSlug')
            ->add('title')
            ->add('slug')
            ->add('code')
            ->add('description')
            ->add('sumT')
            ->add('sumU')
            ->add('sumV')
            ->add('upperT', EntityType::class, [
                'class' => Aacb::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aacb::class,
        ]);
    }
}
