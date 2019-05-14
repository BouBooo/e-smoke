<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, $this->formAttr('','Votre email'))
            ->add('username', TextType::class, $this->formAttr('Nom d\'utilisateur', 'Votre nom d\'utilisateur'))
            ->add('password', PasswordType::class, $this->formAttr('Mot de passe', 'Votre mot de passe'))
            ->add('confirmPassword', PasswordType::class, $this->formAttr('Confirmation du mot de passe', 'Confirmez votre mot de passe'))
        ;
    }

    public function formAttr(string $label, string $placeholder) 
    {
        return [
            'required' => true,
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder,
            ]
            
        ];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
