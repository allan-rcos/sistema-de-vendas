<?php

namespace App\Model;

class Produto
{
    function __construct(
        private readonly int $id,
        private string       $desc,
        private float        $value,
        private TipoProduto  $tipoProduto
    ){
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function getDesc(): string
    {
        return $this->desc;
    }

    public function setDesc(string $desc): void
    {
        $this->desc = $desc;
    }

    public function getTipoProduto(): TipoProduto
    {
        return $this->tipoProduto;
    }

    public function setTipoProduto(TipoProduto $tipoProduto): void
    {
        $this->tipoProduto = $tipoProduto;
    }
}