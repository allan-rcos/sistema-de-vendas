<?php

namespace App\Entity;

use App\Enum\FormasPagamento;
use App\Repository\PedidoRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Produto>
     */
    #[ORM\ManyToMany(targetEntity: Produto::class, inversedBy: 'pedidos')]
    private Collection $produtos;

    #[ORM\Column]
    private ?float $total = 0;

    #[ORM\Column(enumType: FormasPagamento::class)]
    private ?FormasPagamento $forma_de_pagamento = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->produtos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Produto>
     */
    public function getProdutos(): Collection
    {
        return $this->produtos;
    }

    public function addProduto(Produto $produto): static
    {
        if (!$this->produtos->contains($produto)) {
            $this->produtos->add($produto);
            $this->total += $produto->getValue();
        }

        return $this;
    }

    public function removeProduto(Produto $produto): static
    {
        $this->produtos->removeElement($produto);

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function getFormaDePagamento(): ?FormasPagamento
    {
        return $this->forma_de_pagamento;
    }

    public function setFormaDePagamento(FormasPagamento $forma_de_pagamento): static
    {
        $this->forma_de_pagamento = $forma_de_pagamento;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
