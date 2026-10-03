<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlanCard extends Component
{
    public $plan;
    public $classes;
    public $url;

    public function __construct($plan, $url = null, $classes = 'w-100')
    {
        $this->plan = $plan;
        $this->classes = $classes;
        $this->url = $url ?? (auth()->check()
            ? route('site.plans')
            : route('register'));
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.plan-card');
    }
}
