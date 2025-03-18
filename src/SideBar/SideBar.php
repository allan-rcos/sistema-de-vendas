<?php

namespace App\SideBar;

use App\SideBar\Buttons\SideBarButtonInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final readonly class SideBar
{
    function __construct(
        #[AutowireIterator(SideBarButtonInterface::class, indexAttribute: 'key')]
        private iterable $buttons,
    ){
    }

    /**
     * @return array<string, SideBarButtonInterface>
     */
    public function buttons(): array
    {
        $buttons = [];

        foreach ($this->buttons as $name => $button) {
            $buttons[$name] = $button;
        }

        return $buttons;
    }
}