<?php

namespace App\Form;

use App\Entity\Wwww;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WwwwType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categ')
            ->add('fai')
            ->add('mmm')
            ->add('nnn')
            ->add('ppp')
            ->add('status')
            ->add('extra')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wwww::class,
        ]);
    }
}
