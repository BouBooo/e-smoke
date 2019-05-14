<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Liquid;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class LiquidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('flavor')
            ->add('price')
            ->add('category',EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('mark',EntityType::class, [
                'class' => Mark::class,
                'choice_label' => 'name'
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Liquid::class,
        ]);
    }
}
