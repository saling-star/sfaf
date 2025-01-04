<?php

namespace App\Form;

use App\Entity\Xxxx as DcmntEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class XxxxFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach(DcmntEntity::FIELDTYPE as $field=>$type)
            if($type == 'datetime')
                $builder->add($field, DateTimeType::class, [
                    'widget' => 'single_text',// renders it as a single text box
                ]);
            else $builder->add($field);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DcmntEntity::class,
        ]);
    }
}
