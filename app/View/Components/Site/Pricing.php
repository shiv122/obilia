<?php

namespace App\View\Components\Site;

use Illuminate\View\Component;

class Pricing extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $packages;
    public function __construct(
        $packages = null
    ) {
        if ($packages == null) {
            $this->packages = \App\Models\Package::active()
                ->with(['perks'])
                ->get();
        } else {
            $this->packages = $packages;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.pricing');
    }
}
