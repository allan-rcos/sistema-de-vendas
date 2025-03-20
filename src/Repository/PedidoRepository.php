<?php

namespace App\Repository;

use App\Entity\Pedido;
use App\Enum\FormasPagamento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pedido>
 */
class PedidoRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pedido::class);
    }

    public function createFindAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder("pedido")
            ->select("pedido");
    }


    public function describeWithFormaDePagamento(FormasPagamento $fdp): array
    {
        $qb = $this->createQueryBuilder('pedido')
            ->addOrderBy('pedido.forma_de_pagamento', Order::Descending->value)
            ->addSelect('COUNT(pedido.id) AS count')
            ->addSelect('SUM(pedido.total) as total')
            ->andWhere("pedido.forma_de_pagamento = :forma_de_pagamento")
            ->setParameter("forma_de_pagamento", $fdp)
        ;
        $result = $qb->getQuery()->getResult()[0];
        return ["count" => $result["count"], "sum" => round($result["total"], 2)];
    }

    public function describeByFormaDePagamento(): array
    {
        $qb = $this->createQueryBuilder('pedido')
            ->addOrderBy('pedido.forma_de_pagamento', Order::Descending->value)
            ->addSelect('COUNT(pedido.id) AS count')
            ->addSelect('SUM(pedido.total) as total')
            ->addGroupBy("pedido.forma_de_pagamento")
        ;
        $result = $qb->getQuery()->getResult();

        $organized_result = [];
        foreach ($result as $pedido) /* @var $pedido array{0: Pedido, "count": int, "total": float} */
            $organized_result[$pedido[0]->getFormaDePagamento()->name] = [
                "count" => $pedido["count"],
                "sum" => round($pedido["total"], 2)
            ];

        return $organized_result;
    }
}
