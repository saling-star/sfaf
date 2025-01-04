<?php

namespace App\Form;

use App\Entity\Qaaa;
use App\Entity\Qbbb;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QaaaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('upvId')
            ->add('title')
            ->add('slug')
            ->add('description')
            ->add('message')
            ->add('mailFrom')
            ->add('mailTo')
            ->add('returnLink')
            ->add('upperV', EntityType::class, [
                'class' => Qbbb::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Qaaa::class,
        ]);
    }
}
