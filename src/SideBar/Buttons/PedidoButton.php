<?php

namespace App\SideBar\Buttons;

use App\Enum\PedidoHeaders;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem('pedidos')]
final class PedidoButton extends AbstractSideBarButton
{

    public function getName(): string
    {
        return 'Pedidos';
    }

    public function getPathName(): string
    {
        return "Pedido";
    }

    public function getSVGFileName(): string
    {
        return 'svg/basket.svg.twig';
    }

    public function getEnum(): string
    {
        return PedidoHeaders::class;
    }
}