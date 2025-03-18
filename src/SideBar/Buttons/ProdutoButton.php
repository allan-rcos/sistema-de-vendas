<?php

namespace App\SideBar\Buttons;

use App\Enum\ProdutoHeaders;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem('produtos')]
final class ProdutoButton extends AbstractSideBarButton
{

    public function getName(): string
    {
        return 'Produto';
    }

    public function getPathName(): string
    {
        return "Produto";
    }

    public function getSVGFileName(): string
    {
        return 'svg/pizza.svg.twig';
    }

    public function getEnum(): string
    {
        return ProdutoHeaders::class;
    }
}