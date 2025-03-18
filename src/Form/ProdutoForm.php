<?php

namespace App\Form;

use App\Entity\Produto;
use App\Entity\TipoProduto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProdutoForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add("description")
            ->add("value", NumberType::class, [
                "html5"=>true,
                "scale"=>2,
                "empty_data"=>"0"
            ])
            ->add("tipoProduto", EntityType::class, [
                "class"=>TipoProduto::class,
                "placeholder"=>"Selecione o Tipo desse produto.",
                "invalid_message"=>"Tipo inválido."
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', Produto::class);
    }

}