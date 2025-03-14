<?php

namespace App\Repository;

use App\Model\TipoProduto;
use Psr\Log\LoggerInterface;

readonly class TipoProdutoModelRepository
{

    function __construct(
      private LoggerInterface $logger
    ){
    }

    /**
     * @return TipoProduto[]
     */
    function fetchAll(): array
    {
        $this->logger->info("Retornando todos os tipos de produto.");
        return [
            new TipoProduto(
                0,
                "Pizzas"
            ),
            new TipoProduto(
                1,
                "Hamburgers"
            ),
            new TipoProduto(
                2,
                "Sucos de Garrafa"
            )
        ];
    }

    function fetch(int $id): ?TipoProduto
    {
        foreach ($this->fetchAll() as $tipoProduto) if ($tipoProduto->getId() === $id) return $tipoProduto;
        return null;
    }
}