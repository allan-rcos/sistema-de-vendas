<?php

namespace App\Factory;

use App\Entity\TipoProduto;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<TipoProduto>
 */
final class TipoProdutoFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    private const DESCRIPTIONS = [
        "Smartphone",
        "Notebook",
        "Tablet",
        "Fones de ouvido sem fio",
        "Smartwatch",
        "Câmera digital",
        "Impressora",
        "Roteadores",
        "Console de videogame",
        "Televisão",
        "Livro",
        "Roupa",
        "Calçado",
        "Móvel",
        "Eletrodoméstico",
        "Ferramenta",
        "Material de construção",
        "Brinquedo",
        "Alimento",
        "Bebida"
    ];
    public function __construct()
    {
    }

    public static function class(): string
    {
        return TipoProduto::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'description' => self::faker()->randomElement(self::DESCRIPTIONS),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(TipoProduto $tipoProduto): void {})
        ;
    }
}
