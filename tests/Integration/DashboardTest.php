<?php

namespace App\Tests\Integration;

use App\Enum\FormasPagamento;
use App\Factory\PedidoFactory;
use App\Factory\ProdutoFactory;
use App\Factory\TipoProdutoFactory;
use App\Repository\PedidoRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DashboardTest extends KernelTestCase
{
    use ResetDatabase, Factories;

    public function testIsRepositoryDescribeWithFormaDePagamentoWorking(): void
    {
        self::bootKernel();

        TipoProdutoFactory::createMany(5);
        ProdutoFactory::createMany(20);
        PedidoFactory::createMany(10, function () {
            return [
                "produtos" => ProdutoFactory::randomRange(1, 5)
            ];
        });

        $repository = $this->getPedidoRepository();

        $manually_describe = $this->getManuallyDescribeByFormaDePagamento($repository, FormasPagamento::DINHEIRO);

        $describe = $repository->describeWithFormaDePagamento(FormasPagamento::DINHEIRO);

        $this->assertEquals($manually_describe["sum"], $describe["sum"],
            "Valor contado manualmente '{$manually_describe['sum']}' é diferente de '{$describe['sum']}'");
        $this->assertEquals($manually_describe["count"], $describe["count"],
            "Valor contado manualmente '{$manually_describe['count']}' é diferente de '{$describe['count']}'");
    }

    public function testIsRepositoryDescribeByFormaDePagamentoWorking()
    {
        self::bootKernel();

        TipoProdutoFactory::createMany(5);
        ProdutoFactory::createMany(20);
        PedidoFactory::createMany(10, function () {
            return [
                "produtos" => ProdutoFactory::randomRange(1, 5)
            ];
        });

        $repository = $this->getPedidoRepository();

        $describe = $repository->describebyFormaDePagamento();

        foreach (FormasPagamento::cases() as $value) {
            if (!$describe[$value->name]) continue;
            $manually_describe = $this->getManuallyDescribeByFormaDePagamento($repository, $value);

            $this->assertEquals($manually_describe["sum"], $describe[$value->name]["sum"],
                "Valor contado manualmente '{$manually_describe['sum']}' é diferente de '{$describe[$value->name]['sum']}' na Forma de Pagamento '$value->name'.");
            $this->assertEquals($manually_describe["count"], $describe[$value->name]["count"],
                "Valor contado manualmente '{$manually_describe['count']}' é diferente de '{$describe[$value->name]['count']}' na Forma de Pagamento '$value->name'");
        }
    }

    private function getPedidoRepository(): PedidoRepository
    {
        return self::getContainer()->get(PedidoRepository::class);
    }

    private function getManuallyDescribeByFormaDePagamento(PedidoRepository $repository, FormasPagamento $fdp)
    {
        $pedidos = $repository->findBy(["forma_de_pagamento" => $fdp]);
        $manually_sum = 0;
        $manually_count = 0;
        foreach ($pedidos as $pedido) {
            $manually_count += 1;
            $manually_sum += $pedido->getTotal();
        }
        return ["count" => $manually_count, "sum" => round($manually_sum, 2)];
    }
}
