<?php

namespace App\Form;

use App\Entity\Aacb;
use App\Entity\Abbb;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbbbType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('upuSlug')
            ->add('upvSlug')
            ->add('date')
            ->add('affect')
            ->add('value')
            ->add('description')
            ->add('category')
            ->add('dir')
            ->add('year')
            ->add('month')
            ->add('reference')
            ->add('upperU', EntityType::class, [
                'class' => Aacb::class,
                'choice_label' => 'id',
            ])
            ->add('upperV', EntityType::class, [
                'class' => Aacb::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abbb::class,
        ]);
    }
}
