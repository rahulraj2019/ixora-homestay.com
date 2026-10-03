<?php

namespace App\View\Components;

use App\Services\SiteImageService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SiteImg extends Component
{
    /** @var array<string, mixed>|null */
    public ?array $image;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $slotKey,
        SiteImageService $images,
    ) {
        $this->image = $images->get($slotKey);
    }

    public function render(): View|Closure|string
    {
        return view('components.site-img');
    }
}
