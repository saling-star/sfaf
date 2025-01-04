<?php

namespace App\Form;

use App\Entity\Qbbb;
use App\Entity\Qccc;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QcccType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('upuId')
            ->add('num')
            ->add('name')
            ->add('label')
            ->add('content')
            ->add('upperU', EntityType::class, [
                'class' => Qbbb::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Qccc::class,
        ]);
    }
}
