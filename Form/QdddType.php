<?php

namespace App\Form;

use App\Entity\Qccc;
use App\Entity\Qddd;
use App\Entity\Qeee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QdddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('upuId')
            ->add('upvId')
            ->add('num')
            ->add('name')
            ->add('content')
            ->add('qfffId')
            ->add('upperU', EntityType::class, [
                'class' => Qccc::class,
                'choice_label' => 'id',
            ])
            ->add('upperV', EntityType::class, [
                'class' => Qeee::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Qddd::class,
        ]);
    }
}
