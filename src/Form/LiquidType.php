<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Liquid;
use App\Entity\Category;
use App\Form\RegistrationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LiquidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->formAttr('Nom du produit'))
            ->add('flavor', TextType::class, $this->formAttr('Saveur'))
            ->add('price', IntegerType::class, $this->formAttr('Prix (€)'))
            ->add('category',EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie'
            ])
            ->add('mark',EntityType::class, [
                'class' => Mark::class,
                'choice_label' => 'name',
                'label' => 'Marque'
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Image'
            ])
            ->add('about', TextareaType::class, $this->formAttr('Description'))
        ;
    }

    public function formAttr(string $label) 
    {
        return [
            'required' => true,
            'label' => $label
            
        ];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Liquid::class,
        ]);
    }
}
