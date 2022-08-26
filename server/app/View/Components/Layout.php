<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Layout extends Component
{
    public ?string $route;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Route $route)
    {
        $this->route = $route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout');
    }
}
