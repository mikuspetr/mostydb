<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InfoModal extends Component
{
    public string $modalId;
    public string $message;

    /**
     * Create a new component instance.
     */
    public function __construct(string $modalId = 'infoModal', string $message = '')
    {
        $this->modalId = $modalId;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.info-modal');
    }
}
