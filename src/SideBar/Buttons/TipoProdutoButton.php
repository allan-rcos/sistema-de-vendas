<?php

namespace App\SideBar\Buttons;

use App\Enum\TipoProdutoHeaders;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem('tipos-produto')]
final class TipoProdutoButton extends AbstractSideBarButton
{

    public function getName(): string
    {
        return 'Tipo Produto';
    }

    public function getPathName(): string
    {
        return "TipoProduto";
    }

    public function getSVGFileName(): string
    {
        return 'svg/grid.svg.twig';
    }

    public function getEnum(): string
    {
        return TipoProdutoHeaders::class;
    }
}