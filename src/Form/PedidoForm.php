<?php

namespace App\Form;

use App\Entity\Pedido;
use App\Entity\Produto;
use App\Enum\FormasPagamento;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidoForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        #Not working as well. Memory limit problem
        $builder->add("produtos", CollectionType::class, [
                "entry_type" => EntityType::class,
                "entry_options" => [
                    "class" => Produto::class,
                    "placeholder" => "Selecione um produto.",
                    "invalid_message" => "Produto inválido."
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ]) ->add("formaDePagamento", EnumType::class, [
                "class"=>FormasPagamento::class,
                "invalid_message"=>"Forma inválida.",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault("data_class", Pedido::class);
    }

}