<?php

namespace App\Entity;

use App\Enum\ProdutoHeaders;
use App\Repository\ProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank(message: "A Descrição é obrigatória")]
    #[Regex(pattern: "/^[A-zÀ-ú ]+$/",
        message: "A descrição não pode conter caracteres não alfabéticos.")]
    private ?string $description = null;

    #[ORM\Column]
    #[NotBlank(message: "O valor é obrigatório.")]
    #[Positive(message: "O valor precisa ser maior do que 0.")]
    private ?float $value = 0;

    #[ORM\ManyToOne(inversedBy: 'produtos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TipoProduto $tipo_produto = null;

    /**
     * @var Collection<int, Pedido>
     */
    #[ORM\ManyToMany(targetEntity: Pedido::class, mappedBy: 'produtos')]
    private Collection $pedidos;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getTipoProduto(): ?TipoProduto
    {
        return $this->tipo_produto;
    }

    public function setTipoProduto(?TipoProduto $tipo_produto): static
    {
        $this->tipo_produto = $tipo_produto;

        return $this;
    }

    /**
     * @return Collection<int, Pedido>
     */
    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function addPedido(Pedido $pedido): static
    {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos->add($pedido);
            $pedido->addProduto($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): static
    {
        if ($this->pedidos->removeElement($pedido)) {
            $pedido->removeProduto($this);
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return array_column(ProdutoHeaders::cases(), 'value');
    }

    public function getWithHeader(ProdutoHeaders $header): string
    {
        return match ($header) {
            ProdutoHeaders::ID => number_format($this->getId(), 0, ",", "."),
            ProdutoHeaders::VALUE => number_format($this->getValue(), 2, ",", "."),
            ProdutoHeaders::DESCRIPTION => $this->getDescription()
        };
    }

    public function __toString(): string
    {
        $description = $this->getDescription();
        $value = $this.$this->getWithHeader(ProdutoHeaders::VALUE);
        return "$description (R$$value)";
    }
}
