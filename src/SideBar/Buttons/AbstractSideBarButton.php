<?php

namespace App\SideBar\Buttons;

abstract class AbstractSideBarButton implements SideBarButtonInterface
{
    public function getControllerName(): string
    {
        $path = $this->getPathName();
        return "\\{$path}Controller";
    }
}