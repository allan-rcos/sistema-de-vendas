<?php

namespace App\Form;

use App\Form\Model\LoginFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add("email", EmailType::class, [
            "label"=>"Seu melhor email:",
            "invalid_message" => "Por favor digite um email válido."
        ]) -> add("password", PasswordType::class, [
            'label' => 'Senha:',
            "toggle" => true
        ]) -> add('rememberMe', CheckboxType::class, [
            "label" => "Lembrar de mim.",
            "required" => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault("data_class", LoginFormModel::class);
    }

}