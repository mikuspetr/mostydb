<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InfoModal extends Component
{
    public string $modalId;
    public string $message;
    public string $status = 'info';

    /**
     * Create a new component instance.
     */
    public function __construct(string $modalId = 'infoModal', string $message = '', string $status = 'info')
    {
        $this->modalId = $modalId;
        $this->message = $message;
        $this->status = $status;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.info-modal');
    }
}
