<?php

namespace App\Form;

use App\Form\Model\ConfirmExclusionFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfirmExclusionForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('confirm', null, [
            'label'=>"Confirme a exclusão com seu nome de usuário."
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault("data_class", ConfirmExclusionFormModel::class);
    }

}