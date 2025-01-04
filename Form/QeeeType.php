<?php

namespace App\Form;

use App\Entity\Qaaa;
use App\Entity\Qeee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QeeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('upuId')
            ->add('eString')
            ->add('fString')
            ->add('gText')
            ->add('hText')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('upperU', EntityType::class, [
                'class' => Qaaa::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Qeee::class,
        ]);
    }
}
