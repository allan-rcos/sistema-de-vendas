<?php

namespace App\Factory;

use App\Entity\Produto;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Produto>
 */
final class ProdutoFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Produto::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    private const DESCRIPTIONS = [
        "Galaxy S23", "iPhone 14",
        "Dell XPS 13", "MacBook Air M2",
        "iPad Pro", "Galaxy Tab S8",
        "AirPods Pro", "WH-1000XM5",
        "Apple Watch Series 8", "Galaxy Watch 5",
        "Alpha 7 IV", "EOS R6",
        "LaserJet Pro M404dn", "EcoTank L3250",
        "Archer AX50", "Nest Wifi",
        "PlayStation 5", "Xbox Series X",
        "QN90B", "OLED C2",
        "'Cem Anos de Solidão'", "'O Senhor dos Anéis'",
        "Camiseta de algodão", "Calça jeans",
        "Nike Air Max", "Bota de couro",
        "Sofá de três lugares", "Mesa de jantar",
        "Geladeira duplex", "Máquina de lavar roupa",
        "Furadeira elétrica", "Jogo de chaves de fenda",
        "Saco de cimento", "Tijolo cerâmico",
        "Barbie", "Carrinho de controle remoto",
        "Arroz branco", "Feijão preto",
        "Refrigerante de cola", "Suco de laranja"
    ];
    protected function defaults(): array|callable
    {
        return [
            'description' => self::faker()->randomElement(self::DESCRIPTIONS),
            'tipo_produto' => TipoProdutoFactory::new(),
            'value' => self::faker()->randomFloat(2, max:100),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Produto $produto): void {})
        ;
    }
}
