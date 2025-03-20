<?php

namespace App\Tests\Unit;

use App\Entity\Pedido;
use App\Entity\Produto;
use App\Entity\TipoProduto;
use App\Enum\FormasPagamento;
use PHPUnit\Framework\TestCase;

class PedidoCreationTest extends TestCase
{
    public function testPedidoCreationIsRoundingTheTotal(): void
    {

        $tipoProduto = (new TipoProduto())->setDescription("Eletrônicos");

        $electronics = ["Celular", "Notebook", "Desktop", "Monitor", "Televisão"];
        $produtos = [];
        foreach($electronics as $electronic)
            $produtos[] = (new Produto())
                ->setDescription($electronic)
                ->setTipoProduto($tipoProduto)
                ->setValue(round((float) rand(10, 1000) / (float)rand(10, 100), 2))
                ;
        $pedido = (new Pedido())
            ->setFormaDePagamento(FormasPagamento::DINHEIRO)
            ->addProduto($produtos[rand(0, 4)])
            ->addProduto($produtos[rand(0, 4)])
            ->addProduto($produtos[rand(0, 4)])
        ;

        $rounded = round($pedido->getTotal(), 2);
        $this->assertSame($rounded, $pedido->getTotal(),
            "Valor arredondado '$rounded' é diferente de '{$pedido->getTotal()}'."
        );
    }
}
