<?php

namespace App\SideBar\Buttons;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem('home', priority: 50)]
final class Dashboard extends AbstractSideBarButton
{

    public function getName(): string
    {
        return 'DashBoard';
    }

    public function getEnum(): string
    {
        return "";
    }

    public function getPathName(): string
    {
        return "Home";
    }

    public function getSVGFileName(): string
    {
        return "svg/home.svg.twig";
    }

    public function getControllerName(): string
    {
        return "\MainController";
    }
}