<?php

namespace App\View\Components\Crud;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Header extends Component
{
    private $routePrefix;
    private $routeAction;
    public $itemId = null;
    public $route;
    public $btnClass = 'btn-outline-primary';
    public $btnIconClass = 'bi bi-arrow-90deg-up';
    public $btnText = 'Přehled ';

    public function __construct($itemId = null)
    {
        $this->itemId = $itemId;
        $routeCurrent = Route::current();
        $this->routePrefix = explode('/', $routeCurrent->uri)[0];
        $this->routeAction = $routeCurrent->getActionMethod();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        switch($this->routeAction)
        {
            case 'index':
                $this->btnClass = 'btn-outline-success';
                $this->btnIconClass = 'bi bi-plus';
                $this->btnText = 'Vytvořit '.trans_choice('crud.'.$this->routePrefix,0);
                $this->route = route($this->routePrefix.'.create');
                break;
            case 'show':
                $this->btnIconClass = 'bi bi-pencil';
                $this->btnText = 'Upravit '.trans_choice('crud.'.$this->routePrefix,0);
                $this->route = route($this->routePrefix.'.edit', [$this->itemId]);
                break;
            default:
                $this->btnText = 'Přehled '.trans_choice('crud.'.$this->routePrefix,1);
                $this->route = route($this->routePrefix.'.index');
        }
        return view('components.crud.header');
    }
}
