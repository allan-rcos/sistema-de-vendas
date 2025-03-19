<?php

namespace App\Entity;

use App\Enum\TipoProdutoHeaders;
use App\Repository\TipoProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TipoProdutoRepository::class)]
#[UniqueEntity(
    fields: ["description"],
    message: "Esse tipo de produto já existe."
)]
class TipoProduto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "A Descrição é obrigatória")]
    #[Assert\Regex(pattern: "/^[A-zÀ-ú ]+$/",
        message: "A descrição não pode conter caracteres não alfabéticos.")]
    private ?string $description = null;

    /**
     * @var Collection<int, Produto>
     */
    #[ORM\OneToMany(targetEntity: Produto::class, mappedBy: 'tipo_produto', cascade: ["remove"])]
    private Collection $produtos;

    public function __construct()
    {
        $this->produtos = new ArrayCollection();
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
            $produto->setTipoProduto($this);
        }

        return $this;
    }

    public function removeProduto(Produto $produto): static
    {
        if ($this->produtos->removeElement($produto)) {
            // set the owning side to null (unless already changed)
            if ($produto->getTipoProduto() === $this) {
                $produto->setTipoProduto(null);
            }
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return array_column(TipoProdutoHeaders::cases(), 'value');
    }

    public function getWithHeader(TipoProdutoHeaders $header): string
    {
        return match ($header) {
            TipoProdutoHeaders::ID => number_format($this->getId(), 0, ",", "."),
            TipoProdutoHeaders::DESCRIPTION => $this->getDescription(),
        };
    }

    public function __toString(): string
    {
        return $this->getDescription();
    }
}
