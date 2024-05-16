<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardComponent extends Component
{
    public $cards;
 
    public function __construct($cards)
    {
        $this->cards = $cards;
    }

    public function render(): View|Closure|string
    {
        return view('components.card-component');
    }
}
