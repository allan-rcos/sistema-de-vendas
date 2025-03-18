<?php

namespace App\SideBar\Buttons;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface SideBarButtonInterface
{

    public function getName(): string;

    public function getEnum(): string;

    public function getPathName(): string;

    public function getControllerName(): string;

    public function getSVGFileName(): string;
}