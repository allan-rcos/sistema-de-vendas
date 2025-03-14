<?php

namespace App\DataFixtures;

use App\Factory\PedidoFactory;
use App\Factory\ProdutoFactory;
use App\Factory\TipoProdutoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        // $manager->flush();

        $tipos_produto = TipoProdutoFactory::createMany(5);
        ProdutoFactory::createMany(10, function () use ($tipos_produto) {
            return ['tipo_produto' => $tipos_produto[array_rand($tipos_produto)]];
        });
        PedidoFactory::createOne([
            "produtos" => ProdutoFactory::randomRange(1, 5)
        ]);

        $manager->flush();
    }
}
