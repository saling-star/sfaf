<?php

namespace App\Form;

use App\Entity\User as DcmntEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach(DcmntEntity::FIELDTYPE as $field=>$type)
            if($type == 'datetime')
                $builder->add($field, DateTimeType::class, [
                    'widget' => 'single_text',// renders it as a single text box
                ]);
            elseif($type == 'array'){ //JsonArray
                $builder->add($field, TextType::class);
                $builder->get($field) //DataTransformer
                    ->addModelTransformer(new CallbackTransformer(
                        function ($tagsAsArray): string {
                            // transform the array to a string
                            return implode(', ', $tagsAsArray);
                        },
                        function ($tagsAsString): array {
                            // transform the string back to an array
                            return explode(', ', $tagsAsString);
                        }
                    ))
                ;
            } else $builder->add($field);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DcmntEntity::class,
        ]);
    }
}
