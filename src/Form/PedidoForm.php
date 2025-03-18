<?php

namespace App\Form;

use App\Entity\Pedido;
use App\Entity\Produto;
use App\Enum\FormasPagamento;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidoForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        #Not working as well. Memory limit problem
        $builder->add("produtos", EntityType::class, [
                "class"=>Produto::class,
                'expanded'  => true,
                'multiple'  => true,
                "invalid_message"=>"Produto inválido."
            ]) ->add("formaDePagamento", EnumType::class, [
                "class"=>FormasPagamento::class,
                "invalid_message"=>"Forma inválida."
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Pedido::class);
    }

}