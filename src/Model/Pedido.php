<?php

namespace App\Model;

use App\Enum\FormasPagamento;
use DateTime;

class Pedido
{
    /**
     * @param int $id
     * @param DateTime $data
     * @param Produto[] $produtos
     * @param float $total
     * @param FormasPagamento $formasPagamento
     */
    function __construct(
        private readonly int    $id,
        private DateTime        $data,
        private array           $produtos,
        private float           $total,
        private FormasPagamento $formasPagamento
    ){
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getData(): DateTime
    {
        return $this->data;
    }

    public function setData(DateTime $data): void
    {
        $this->data = $data;
    }

    /**
     * @return Produto[]
     */
    public function getProdutos(): array
    {
        return $this->produtos;
    }

    /**
     * @param Produto[] $produtos
     * @return void
     */
    public function setProdutos(array $produtos): void
    {
        $this->produtos = $produtos;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function getFormasPagamento(): FormasPagamento
    {
        return $this->formasPagamento;
    }

    public function setFormasPagamento(FormasPagamento $formasPagamento): void
    {
        $this->formasPagamento = $formasPagamento;
    }
}