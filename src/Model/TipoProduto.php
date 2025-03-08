<?php

namespace App\Model;

class TipoProduto
{
    function __construct(
        private readonly int $id,
        private string       $desc,
    ){
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDesc(): string
    {
        return $this->desc;
    }

    public function setDesc(string $desc): void
    {
        $this->desc = $desc;
    }
}